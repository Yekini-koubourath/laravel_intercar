<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StockEntryController extends Controller
{
    /**
     * Liste des entrées enregistrées.
     */
    public function index(Request $request)
    {
        $purchases = Purchase::with(['supplier', 'product', 'user'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $s = trim($request->q);

                $query->where(function ($w) use ($s) {
                    $w->where('number', 'like', "%{$s}%")
                        ->orWhere('supplier_reference', 'like', "%{$s}%")
                        ->orWhereHas('product', fn ($p) => $p
                            ->where('name', 'like', "%{$s}%")
                            ->orWhere('reference', 'like', "%{$s}%"));
                });
            })
            ->when(
                $request->filled('supplier_id'),
                fn ($q) => $q->where('supplier_id', $request->supplier_id)
            )
            ->when(
                $request->filled('from'),
                fn ($q) => $q->whereDate('purchase_date', '>=', $request->from)
            )
            ->when(
                $request->filled('to'),
                fn ($q) => $q->whereDate('purchase_date', '<=', $request->to)
            )
            ->orderByDesc('purchase_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('stock.entries.index', [
            'purchases'     => $purchases,
            'suppliers'     => Supplier::orderBy('name')->get(),
            'countEntries'  => Purchase::count(),
            'totalQuantity' => Purchase::sum('quantity'),
            'totalCost'     => Purchase::sum('total_cost_xof'),
        ]);
    }

    /**
     * Formulaire de nouvelle entrée.
     */
    public function create()
    {
        $rates = [];

        foreach (['NGN', 'EUR', 'USD'] as $currency) {
            $rates[$currency] = ExchangeRate::latestToXof($currency);
        }

        return view('stock.entries.create', [
            'products'     => Product::where('status', '!=', 'inactif')
                ->orderBy('name')
                ->get(),
            'suppliers'    => Supplier::orderBy('name')->get(),
            'rate'         => $rates['NGN'],
            'rates'        => $rates,
            'nextNumber'   => Purchase::nextNumber(),
            'units'        => Purchase::UNITS,
            'currencies'   => Purchase::CURRENCIES,
            'expenseTypes' => Purchase::EXPENSE_TYPES,
        ]);
    }

    /**
     * Enregistrer une entrée :
     * achat + frais + mouvement de stock + mise à jour du produit.
     * Les calculs sont effectués côté serveur.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'purchase_date'      => ['required', 'date', 'before_or_equal:today'],
            'supplier_id'        => [
                'nullable',
                'exists:suppliers,id',
                'required_without:new_supplier',
            ],
            'new_supplier'       => ['nullable', 'string', 'max:255'],
            'supplier_reference' => ['nullable', 'string', 'max:255'],
            'product_id'         => ['required', 'exists:products,id'],
            'quantity'           => ['required', 'integer', 'min:1'],
            'unit'               => ['required', Rule::in(array_keys(Purchase::UNITS))],
            'currency'           => ['required', Rule::in(array_keys(Purchase::CURRENCIES))],
            'unit_price'         => ['required', 'numeric', 'min:0'],
            'exchange_rate'      => ['nullable', 'numeric', 'gt:0'],

            // Le prix de vente est désormais facultatif.
            'selling_price'      => ['nullable', 'numeric', 'min:0'],

            'observation'        => ['nullable', 'string'],

            'expenses'               => ['nullable', 'array'],
            'expenses.*.type'        => [
                'required',
                Rule::in(array_keys(Purchase::EXPENSE_TYPES)),
            ],
            'expenses.*.description' => ['nullable', 'string', 'max:255'],
            'expenses.*.amount'      => ['required', 'numeric', 'min:0'],
            'expenses.*.currency'    => [
                'required',
                Rule::in(array_keys(Purchase::CURRENCIES)),
            ],
        ], [
            'supplier_id.required_without' =>
                'Veuillez choisir ou saisir un fournisseur.',
            'purchase_date.before_or_equal' =>
                'La date de l’achat ne peut pas être dans le futur.',
        ]);

        $expensesInput = $data['expenses'] ?? [];
        $purchaseCurrency = $data['currency'];

        // Charger les derniers taux connus.
        $latestRates = [];

        foreach (['NGN', 'EUR', 'USD'] as $currency) {
            $latestRates[$currency] = ExchangeRate::latestToXof($currency);
        }

        // Déterminer le taux de l'achat.
        // Le taux manuel est prioritaire lorsqu'il est fourni.
        $purchaseRate = null;
        $purchaseLatestRate = null;

        if ($purchaseCurrency !== 'XOF') {
            $purchaseLatestRate = $latestRates[$purchaseCurrency];

            $purchaseRate = ! empty($data['exchange_rate'])
                ? (float) $data['exchange_rate']
                : $purchaseLatestRate?->rate;

            if (! is_numeric($purchaseRate) || (float) $purchaseRate <= 0) {
                throw ValidationException::withMessages([
                    'exchange_rate' =>
                        "Aucun taux valide n'est disponible pour {$purchaseCurrency} → XOF. "
                        . 'Saisissez un taux ou mettez à jour les taux de change.',
                ]);
            }
        }

        // Vérifier les taux nécessaires aux frais annexes.
        foreach ($expensesInput as $index => $expense) {
            $currency = $expense['currency'];

            if ($currency === 'XOF') {
                continue;
            }

            if ($currency === $purchaseCurrency && $purchaseRate !== null) {
                continue;
            }

            if (! $latestRates[$currency]) {
                throw ValidationException::withMessages([
                    "expenses.{$index}.currency" =>
                        "Aucun taux enregistré pour {$currency} → XOF. "
                        . 'Mettez à jour les taux de change avant de continuer.',
                ]);
            }
        }

        $purchase = DB::transaction(function () use (
            $data,
            $expensesInput,
            $latestRates,
            $purchaseCurrency,
            $purchaseRate,
            $purchaseLatestRate
        ) {
            $isLatest = $purchaseLatestRate !== null
                && $purchaseRate !== null
                && abs($purchaseLatestRate->rate - $purchaseRate) < 0.00000001;

            // Convertir une somme dans sa devise d'origine vers le XOF.
            $toXof = function (float $amount, string $currency) use (
                $latestRates,
                $purchaseCurrency,
                $purchaseRate
            ): float {
                if ($currency === 'XOF') {
                    return $amount;
                }

                if ($currency === $purchaseCurrency && $purchaseRate !== null) {
                    return $amount * $purchaseRate;
                }

                $rate = $latestRates[$currency] ?? null;

                if (! $rate || $rate->rate <= 0) {
                    throw new \RuntimeException(
                        "Taux de change indisponible pour {$currency} → XOF."
                    );
                }

                return $amount * $rate->rate;
            };

            // Fournisseur.
            $supplier = null;

            if (! empty(trim($data['new_supplier'] ?? ''))) {
                $supplier = Supplier::firstOrCreate([
                    'name' => trim($data['new_supplier']),
                ]);
            } elseif (! empty($data['supplier_id'])) {
                $supplier = Supplier::find($data['supplier_id']);
            }

            // Calcul du prix d'achat.
            $qty = (int) $data['quantity'];
            $purchaseOriginal = $qty * (float) $data['unit_price'];
            $purchaseXof = $toXof($purchaseOriginal, $purchaseCurrency);

            // Calcul des frais annexes.
            $expenseRows = [];
            $expensesXof = 0.0;

            foreach ($expensesInput as $expense) {
                $amount = (float) $expense['amount'];
                $xof = $toXof($amount, $expense['currency']);
                $expensesXof += $xof;

                $expenseRows[] = [
                    'type'        => $expense['type'],
                    'description' => $expense['description'] ?? null,
                    'amount'      => $amount,
                    'currency'    => $expense['currency'],
                    'amount_xof'  => round($xof, 2),
                ];
            }

            // Calcul du prix de revient.
            $totalCost = $purchaseXof + $expensesXof;
            $unitCost = $totalCost / $qty;

            // Charger le produit.
            $product = Product::lockForUpdate()->findOrFail($data['product_id']);

            // Conserver le prix de vente actuel si aucun nouveau prix n'est fourni.
            $sellingPrice = isset($data['selling_price'])
                ? (float) $data['selling_price']
                : (float) ($product->selling_price ?? 0);

            // Calcul de la marge historique.
            $unitMargin = $sellingPrice - $unitCost;

            $marginPercent = $unitCost > 0
                ? ($unitMargin / $unitCost) * 100
                : 0;

            // Mise à jour du stock.
            $stockAvant = $product->quantity;
            $stockApres = $stockAvant + $qty;
            $number = Purchase::nextNumber();

            $movement = StockMovement::create([
                'product_id'  => $product->id,
                'user_id'     => Auth::id(),
                'type'        => 'entree',
                'quantity'    => $qty,
                'stock_avant' => $stockAvant,
                'stock_apres' => $stockApres,
                'motif'       => Str::limit(
                    'Achat ' . $number . ($supplier ? ' - ' . $supplier->name : ''),
                    250,
                    ''
                ),
                'observation' => $data['observation'] ?? null,
            ]);

            // Mettre à jour la quantité et le prix de revient du produit.
            $productData = [
                'quantity'       => $stockApres,
                'purchase_price' => round($unitCost, 2),
            ];

            // Ne modifier le prix de vente que si un nouveau prix est fourni.
            if (isset($data['selling_price'])) {
                $productData['selling_price'] = $sellingPrice;
            }

            $product->update($productData);

            // Enregistrer l'achat et son taux historique.
            $purchase = Purchase::create([
                'number'                  => $number,
                'purchase_date'           => $data['purchase_date'],
                'supplier_id'             => $supplier?->id,
                'supplier_reference'      => $data['supplier_reference'] ?? null,
                'product_id'              => $product->id,
                'user_id'                 => Auth::id(),
                'stock_movement_id'       => $movement->id,
                'exchange_rate_id'        => $isLatest
                    ? $purchaseLatestRate->id
                    : null,
                'quantity'                => $qty,
                'unit'                    => $data['unit'],
                'currency'                => $purchaseCurrency,
                'unit_price'              => $data['unit_price'],
                'exchange_rate'           => $purchaseRate,
                'exchange_rate_source'    => $purchaseCurrency === 'XOF'
                    ? null
                    : ($isLatest ? $purchaseLatestRate->source : 'manuel'),
                'purchase_total_original' => round($purchaseOriginal, 2),
                'purchase_total_xof'      => round($purchaseXof, 2),
                'expenses_total_xof'      => round($expensesXof, 2),
                'total_cost_xof'          => round($totalCost, 2),
                'unit_cost_xof'           => round($unitCost, 2),
                'selling_price'           => $sellingPrice,
                'unit_margin'             => round($unitMargin, 2),
                'margin_percent'          => round($marginPercent, 2),
                'observation'             => $data['observation'] ?? null,
            ]);

            // Enregistrer les frais annexes.
            if (! empty($expenseRows)) {
                $purchase->expenses()->createMany($expenseRows);
            }

            return $purchase;
        });

        return redirect()
            ->route('stock.entries.show', $purchase)
            ->with(
                'success',
                "Entrée {$purchase->number} enregistrée : le stock a été mis à jour."
            );
    }

    /**
     * Détail d'une entrée.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load([
            'supplier',
            'product',
            'user',
            'expenses',
            'stockMovement',
        ]);

        return view('stock.entries.show', [
            'purchase'     => $purchase,
            'units'        => Purchase::UNITS,
            'expenseTypes' => Purchase::EXPENSE_TYPES,
        ]);
    }
}
