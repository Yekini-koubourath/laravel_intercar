<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseExpense;
use App\Models\SaleItem;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TarificationController extends Controller
{
    /**
     * Afficher la page de tarification.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $query = Product::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('reference', 'like', '%' . $search . '%');
                });
            });

        // Valeur totale du stock.
        $totals = (clone $query)
            ->selectRaw(
                'COALESCE(SUM(COALESCE(purchase_price, 0) * quantity), 0) as cost'
            )
            ->selectRaw(
                'COALESCE(SUM(COALESCE(selling_price, 0) * quantity), 0) as sale'
            )
            ->first();

        $totalCost = (float) ($totals->cost ?? 0);
        $totalSale = (float) ($totals->sale ?? 0);
        $totalMargin = $totalSale - $totalCost;

        // Produits affichés dans le tableau.
        $products = (clone $query)
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $ids = $products->pluck('id');

        // Dernier achat contenant réellement des informations de prix.
        // Les entrées de stock simples ne remplacent pas ces informations.
        $lastPurchases = Purchase::whereIn('product_id', $ids)
            ->whereNotNull('unit_price')
            ->orderByDesc('id')
            ->get()
            ->unique('product_id')
            ->keyBy('product_id');

        // Quantités vendues et chiffre d'affaires.
        $sales = SaleItem::query()
            ->selectRaw(
                'product_id, SUM(quantity) as qty_sold, SUM(total) as revenue'
            )
            ->whereIn('product_id', $ids)
            ->groupBy('product_id')
            ->get()
            ->keyBy('product_id');

        // Derniers taux de change connus.
        $rates = [];

        foreach (['NGN', 'EUR', 'USD'] as $currency) {
            $rate = ExchangeRate::latestToXof($currency);
            $rates[$currency] = $rate ? (float) $rate->rate : 0;
        }

        return view('tarification.index', [
            'products' => $products,
            'search' => $search,
            'totalCost' => $totalCost,
            'totalSale' => $totalSale,
            'totalMargin' => $totalMargin,
            'lastPurchases' => $lastPurchases,
            'sales' => $sales,

            'entryProducts' => Product::orderBy('name')
                ->get([
                    'id',
                    'name',
                    'reference',
                    'type',
                    'quantity',
                    'selling_price',
                    'purchase_price',
                    'unit',
                ]),

            'suppliers' => Supplier::orderBy('name')->get(),
            'currencies' => Purchase::CURRENCIES,
            'rates' => $rates,
            'expenseTypes' => Purchase::EXPENSE_TYPES,
            'units' => Purchase::UNITS,
            'nextNumber' => Purchase::nextNumber(),
        ]);
    }

    /**
     * Enregistrer un achat avec ses frais et sa nouvelle tarification.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'unit' => [
                'required',
                Rule::in(array_keys(Purchase::UNITS)),
            ],

            'supplier_id' => [
                'nullable',
                'required_without:new_supplier',
                'exists:suppliers,id',
            ],

            'new_supplier' => [
                'nullable',
                'string',
                'max:255',
            ],

            'supplier_reference' => [
                'nullable',
                'string',
                'max:255',
            ],

            'purchase_date' => [
                'required',
                'date',
            ],

            'currency' => [
                'required',
                Rule::in(array_keys(Purchase::CURRENCIES)),
            ],

            'unit_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'selling_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'expenses' => [
                'nullable',
                'array',
            ],

            'expenses.*.type' => [
                'required',
                Rule::in(array_keys(Purchase::EXPENSE_TYPES)),
            ],

            'expenses.*.description' => [
                'nullable',
                'string',
                'max:255',
            ],

            'expenses.*.amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'expenses.*.currency' => [
                'required',
                Rule::in(array_keys(Purchase::CURRENCIES)),
            ],

            'observation' => [
                'nullable',
                'string',
            ],
        ], [
            'product_id.required' => 'Veuillez sélectionner un produit.',
            'quantity.required' => 'Veuillez saisir la quantité.',
            'quantity.min' => 'La quantité doit être au moins égale à 1.',
            'supplier_id.required_without' =>
                'Veuillez choisir ou saisir un fournisseur.',
            'currency.required' => 'Veuillez choisir la devise d’achat.',
            'unit_price.required' => 'Veuillez saisir le prix d’achat.',
            'selling_price.required' =>
                'Le prix de vente calculé est obligatoire.',
        ]);

        // Une nouvelle ligne de frais sans montant n'est pas enregistrée.
        $expenses = collect($data['expenses'] ?? [])
            ->filter(fn ($expense) => (float) $expense['amount'] > 0)
            ->values();

        $purchase = DB::transaction(function () use ($data, $expenses) {
            // Créer ou retrouver le fournisseur.
            $supplier = null;
            $newSupplierName = trim($data['new_supplier'] ?? '');

            if ($newSupplierName !== '') {
                $supplier = Supplier::firstOrCreate([
                    'name' => $newSupplierName,
                ]);
            } elseif (!empty($data['supplier_id'])) {
                $supplier = Supplier::findOrFail($data['supplier_id']);
            }

            // Verrouiller le produit pour éviter les conflits de stock.
            $product = Product::lockForUpdate()
                ->findOrFail($data['product_id']);

            $quantity = (int) $data['quantity'];
            $unitPrice = (float) $data['unit_price'];
            $currency = strtoupper($data['currency']);

            // Déterminer le taux d'achat vers le FCFA.
            $exchangeRate = 1.0;
            $exchangeRateId = null;
            $exchangeRateSource = null;

            if ($currency !== 'XOF') {
                $rateRecord = ExchangeRate::latestToXof($currency);

                if (!$rateRecord || (float) $rateRecord->rate <= 0) {
                    throw ValidationException::withMessages([
                        'currency' =>
                            "Aucun taux de change valide n'est disponible pour {$currency} vers XOF.",
                    ]);
                }

                $exchangeRate = (float) $rateRecord->rate;
                $exchangeRateId = $rateRecord->id;
                $exchangeRateSource = $rateRecord->source;
            }

            // Prix d'achat converti en FCFA.
            $purchaseTotalOriginal = round(
                $unitPrice * $quantity,
                2
            );

            $purchaseTotalXof = round(
                $purchaseTotalOriginal * $exchangeRate,
                2
            );

            // Convertir les frais en FCFA.
            $expensesTotalXof = 0;
            $preparedExpenses = [];

            foreach ($expenses as $index => $expense) {
                $expenseCurrency = strtoupper($expense['currency']);
                $expenseAmount = (float) $expense['amount'];

                if ($expenseCurrency === 'XOF') {
                    $expenseRate = 1.0;
                } else {
                    $expenseRateRecord =
                        ExchangeRate::latestToXof($expenseCurrency);

                    if (
                        !$expenseRateRecord
                        || (float) $expenseRateRecord->rate <= 0
                    ) {
                        throw ValidationException::withMessages([
                            "expenses.{$index}.currency" =>
                                "Aucun taux de change valide n'est disponible pour {$expenseCurrency} vers XOF.",
                        ]);
                    }

                    $expenseRate = (float) $expenseRateRecord->rate;
                }

                $amountXof = round(
                    $expenseAmount * $expenseRate,
                    2
                );

                $expensesTotalXof += $amountXof;

                $preparedExpenses[] = [
                    'type' => $expense['type'],
                    'description' => $expense['description'] ?? null,
                    'amount' => $expenseAmount,
                    'currency' => $expenseCurrency,
                    'amount_xof' => $amountXof,
                ];
            }

            $expensesTotalXof = round($expensesTotalXof, 2);

            // Coût de revient et marge.
            $totalCostXof = round(
                $purchaseTotalXof + $expensesTotalXof,
                2
            );

            $unitCostXof = round(
                $totalCostXof / $quantity,
                2
            );

            $sellingPrice = (float) $data['selling_price'];

            $unitMargin = round(
                $sellingPrice - $unitCostXof,
                2
            );

            $marginPercent = $unitCostXof > 0
                ? round(($unitMargin / $unitCostXof) * 100, 2)
                : 0;

            // Calculer le nouveau stock.
            $stockAvant = (int) $product->quantity;
            $stockApres = $stockAvant + $quantity;
            $number = Purchase::nextNumber();

            // Enregistrer le mouvement de stock.
            $movement = StockMovement::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'type' => 'entree',
                'quantity' => $quantity,
                'stock_avant' => $stockAvant,
                'stock_apres' => $stockApres,
                'motif' => Str::limit(
                    'Achat ' . $number
                    . ($supplier ? ' - ' . $supplier->name : ''),
                    250,
                    ''
                ),
                'observation' => $data['observation'] ?? null,
            ]);

            // Enregistrer l'achat avec tous ses montants.
            $purchase = Purchase::create([
                'number' => $number,
                'purchase_date' => $data['purchase_date'],
                'supplier_id' => $supplier?->id,
                'supplier_reference' =>
                    $data['supplier_reference'] ?? null,
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'stock_movement_id' => $movement->id,
                'exchange_rate_id' => $exchangeRateId,
                'quantity' => $quantity,
                'unit' => $data['unit'],
                'currency' => $currency,
                'unit_price' => $unitPrice,
                'exchange_rate' => $exchangeRate,
                'exchange_rate_source' => $exchangeRateSource,
                'purchase_total_original' => $purchaseTotalOriginal,
                'purchase_total_xof' => $purchaseTotalXof,
                'expenses_total_xof' => $expensesTotalXof,
                'total_cost_xof' => $totalCostXof,
                'unit_cost_xof' => $unitCostXof,
                'selling_price' => $sellingPrice,
                'unit_margin' => $unitMargin,
                'margin_percent' => $marginPercent,
                'observation' => $data['observation'] ?? null,
            ]);

            // Enregistrer les frais associés à cet achat.
            foreach ($preparedExpenses as $expense) {
                $purchase->expenses()->create($expense);
            }

            // Mettre à jour le stock et les tarifs du produit.
            $product->update([
                'quantity' => $stockApres,
                'purchase_price' => $unitCostXof,
                'selling_price' => $sellingPrice,
            ]);

            return $purchase;
        });

        return redirect()
            ->route('tarification.index')
            ->with(
                'success',
                "Achat {$purchase->number} enregistré. Le stock, le coût de revient et le prix de vente ont été mis à jour."
            );
    }

    /**
     * Modifier uniquement le prix de vente d'un produit.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'selling_price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ], [
            'selling_price.required' =>
                'Le prix de vente est obligatoire.',
            'selling_price.numeric' =>
                'Le prix de vente doit être un nombre valide.',
            'selling_price.min' =>
                'Le prix de vente ne peut pas être négatif.',
        ]);

        $product->update([
            'selling_price' => $data['selling_price'],
        ]);

        return redirect()
            ->route('tarification.index', [
                'q' => $request->input('q', ''),
                'page' => $request->input('page', 1),
            ])
            ->with(
                'success',
                'Le prix de vente a été mis à jour avec succès.'
            );
    }
}
