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
 * Enregistrer une entrée de stock sans modifier les tarifs.
 */
public function store(Request $request)
{
    $data = $request->validate([
        'supplier_id' => [
            'nullable',
            'exists:suppliers,id',
            'required_without:new_supplier',
        ],
        'new_supplier' => ['nullable', 'string', 'max:255'],
        'supplier_reference' => ['nullable', 'string', 'max:255'],
        'product_id' => ['required', 'exists:products,id'],
        'quantity' => ['required', 'integer', 'min:1'],
        'unit' => ['required', Rule::in(array_keys(Purchase::UNITS))],
        'observation' => ['nullable', 'string'],
    ], [
        'supplier_id.required_without' =>
            'Veuillez choisir ou saisir un fournisseur.',
    ]);

    $purchase = DB::transaction(function () use ($data) {
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

        // Verrouiller le produit pendant la mise à jour du stock.
        $product = Product::lockForUpdate()
            ->findOrFail($data['product_id']);

        $quantity = (int) $data['quantity'];
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
                'Entrée ' . $number
                    . ($supplier ? ' - ' . $supplier->name : ''),
                250,
                ''
            ),
            'observation' => $data['observation'] ?? null,
        ]);

        // Modifier uniquement la quantité.
        // Les prix existants restent inchangés.
        $product->update([
            'quantity' => $stockApres,
        ]);

        // Enregistrer l'entrée dans l'historique.
        // Les champs de prix restent vides.
        return Purchase::create([
            'number' => $number,
            'purchase_date' => now()->toDateString(),
            'supplier_id' => $supplier?->id,
            'supplier_reference' => $data['supplier_reference'] ?? null,
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'stock_movement_id' => $movement->id,
            'exchange_rate_id' => null,
            'quantity' => $quantity,
            'unit' => $data['unit'],
            'currency' => null,
            'unit_price' => null,
            'exchange_rate' => null,
            'exchange_rate_source' => null,
            'purchase_total_original' => null,
            'purchase_total_xof' => null,
            'expenses_total_xof' => 0,
            'total_cost_xof' => null,
            'unit_cost_xof' => null,
            'selling_price' => null,
            'unit_margin' => null,
            'margin_percent' => null,
            'observation' => $data['observation'] ?? null,
        ]);
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
