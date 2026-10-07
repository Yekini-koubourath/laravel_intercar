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
            ->when($request->filled('supplier_id'), fn ($q) => $q->where('supplier_id', $request->supplier_id))
            ->when($request->filled('from'), fn ($q) => $q->whereDate('purchase_date', '>=', $request->from))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('purchase_date', '<=', $request->to))
            ->orderByDesc('purchase_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('stock.entries.index', [
            'purchases'      => $purchases,
            'suppliers'      => Supplier::orderBy('name')->get(),
            'countEntries'   => Purchase::count(),
            'totalQuantity'  => Purchase::sum('quantity'),
            'totalCost'      => Purchase::sum('total_cost_xof'),
        ]);
    }

    /**
     * Formulaire de nouvelle entrée.
     */
    public function create()
    {
        return view('stock.entries.create', [
            'products'     => Product::where('status', '!=', 'inactif')->orderBy('name')->get(),
            'suppliers'    => Supplier::orderBy('name')->get(),
            'rate'         => ExchangeRate::latestNgnXof(),
            'nextNumber'   => Purchase::nextNumber(),
            'units'        => Purchase::UNITS,
            'currencies'   => Purchase::CURRENCIES,
            'expenseTypes' => Purchase::EXPENSE_TYPES,
        ]);
    }

    /**
     * Enregistrer l'entrée : achat + frais + mouvement de stock + mise à jour du produit.
     * Tous les calculs sont refaits côté serveur.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'purchase_date'      => ['required', 'date', 'before_or_equal:today'],
            'supplier_id'        => ['nullable', 'exists:suppliers,id', 'required_without:new_supplier'],
            'new_supplier'       => ['nullable', 'string', 'max:255'],
            'supplier_reference' => ['nullable', 'string', 'max:255'],
            'product_id'         => ['required', 'exists:products,id'],
            'quantity'           => ['required', 'integer', 'min:1'],
            'unit'               => ['required', Rule::in(array_keys(Purchase::UNITS))],
            'currency'           => ['required', Rule::in(array_keys(Purchase::CURRENCIES))],
            'unit_price'         => ['required', 'numeric', 'min:0'],
            'exchange_rate'      => ['nullable', 'numeric', 'gt:0'],
            'selling_price'      => ['required', 'numeric', 'min:0'],
            'observation'        => ['nullable', 'string'],

            'expenses'               => ['nullable', 'array'],
            'expenses.*.type'        => ['required', Rule::in(array_keys(Purchase::EXPENSE_TYPES))],
            'expenses.*.description' => ['nullable', 'string', 'max:255'],
            'expenses.*.amount'      => ['required', 'numeric', 'min:0'],
            'expenses.*.currency'    => ['required', Rule::in(array_keys(Purchase::CURRENCIES))],
        ], [
            'supplier_id.required_without' => 'Veuillez choisir ou saisir un fournisseur.',
            'purchase_date.before_or_equal' => 'La date de l\'achat ne peut pas être dans le futur.',
        ]);

        $expensesInput = $data['expenses'] ?? [];

        $usesNgn = $data['currency'] === 'NGN'
            || collect($expensesInput)->contains(fn ($e) => $e['currency'] === 'NGN');

        if ($usesNgn && empty($data['exchange_rate'])) {
            throw ValidationException::withMessages([
                'exchange_rate' => 'Le taux de change NGN → XOF est requis.',
            ]);
        }

        $purchase = DB::transaction(function () use ($data, $expensesInput, $usesNgn) {

            $rate   = $usesNgn ? (float) $data['exchange_rate'] : null;
            $latest = $usesNgn ? ExchangeRate::latestNgnXof() : null;
            $isLatest = $latest && abs($latest->rate - $rate) < 0.00000001;

            $toXof = fn (float $amount, string $cur) => $cur === 'NGN' ? $amount * $rate : $amount;

            // Fournisseur
            $supplier = null;
            if (! empty(trim($data['new_supplier'] ?? ''))) {
                $supplier = Supplier::firstOrCreate(['name' => trim($data['new_supplier'])]);
            } elseif (! empty($data['supplier_id'])) {
                $supplier = Supplier::find($data['supplier_id']);
            }

            // Calculs
            $qty               = (int) $data['quantity'];
            $purchaseOriginal  = $qty * (float) $data['unit_price'];
            $purchaseXof       = $toXof($purchaseOriginal, $data['currency']);

            $expenseRows  = [];
            $expensesXof  = 0;
            foreach ($expensesInput as $e) {
                $xof = $toXof((float) $e['amount'], $e['currency']);
                $expensesXof += $xof;
                $expenseRows[] = [
                    'type'        => $e['type'],
                    'description' => $e['description'] ?? null,
                    'amount'      => $e['amount'],
                    'currency'    => $e['currency'],
                    'amount_xof'  => round($xof, 2),
                ];
            }

            $totalCost     = $purchaseXof + $expensesXof;
            $unitCost      = $totalCost / $qty;
            $unitMargin    = (float) $data['selling_price'] - $unitCost;
            $marginPercent = $unitCost > 0 ? ($unitMargin / $unitCost) * 100 : 0;

            // Stock
            $product     = Product::lockForUpdate()->findOrFail($data['product_id']);
            $stockAvant  = $product->quantity;
            $stockApres  = $stockAvant + $qty;

            $number = Purchase::nextNumber();

            $movement = StockMovement::create([
                'product_id'  => $product->id,
                'user_id'     => Auth::id(),
                'type'        => 'entree',
                'quantity'    => $qty,
                'stock_avant' => $stockAvant,
                'stock_apres' => $stockApres,
                'motif'       => Str::limit('Achat ' . $number . ($supplier ? ' - ' . $supplier->name : ''), 250, ''),
                'observation' => $data['observation'] ?? null,
            ]);

            // Le produit reçoit le nouveau stock, le prix de revient unitaire et le prix de vente
            $product->update([
                'quantity'       => $stockApres,
                'purchase_price' => round($unitCost, 2),
                'selling_price'  => $data['selling_price'],
            ]);

            $purchase = Purchase::create([
                'number'                  => $number,
                'purchase_date'           => $data['purchase_date'],
                'supplier_id'             => $supplier?->id,
                'supplier_reference'      => $data['supplier_reference'] ?? null,
                'product_id'              => $product->id,
                'user_id'                 => Auth::id(),
                'stock_movement_id'       => $movement->id,
                'exchange_rate_id'        => $isLatest ? $latest->id : null,
                'quantity'                => $qty,
                'unit'                    => $data['unit'],
                'currency'                => $data['currency'],
                'unit_price'              => $data['unit_price'],
                'exchange_rate'           => $rate,
                'exchange_rate_source'    => $usesNgn ? ($isLatest ? $latest->source : 'manuel') : null,
                'purchase_total_original' => round($purchaseOriginal, 2),
                'purchase_total_xof'      => round($purchaseXof, 2),
                'expenses_total_xof'      => round($expensesXof, 2),
                'total_cost_xof'          => round($totalCost, 2),
                'unit_cost_xof'           => round($unitCost, 2),
                'selling_price'           => $data['selling_price'],
                'unit_margin'             => round($unitMargin, 2),
                'margin_percent'          => round($marginPercent, 2),
                'observation'             => $data['observation'] ?? null,
            ]);

            if ($expenseRows) {
                $purchase->expenses()->createMany($expenseRows);
            }

            return $purchase;
        });

        return redirect()
            ->route('stock.entries.show', $purchase)
            ->with('success', "Entrée {$purchase->number} enregistrée : le stock a été mis à jour.");
    }

    /**
     * Détail d'une entrée.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'product', 'user', 'expenses', 'stockMovement']);

        return view('stock.entries.show', [
            'purchase'     => $purchase,
            'units'        => Purchase::UNITS,
            'expenseTypes' => Purchase::EXPENSE_TYPES,
        ]);
    }
}