<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Page Stock : état du stock.
     */
    public function index()
    {
        $products = Product::orderBy('name')->get();

        $totalProducts = $products->count();

        $totalStock = $products->sum('quantity');

        $stockFaible = $products->filter(function ($product) {
            return $product->quantity <= $product->stock_minimum;
        })->count();

        return view('stock.index', compact(
            'products',
            'totalProducts',
            'totalStock',
            'stockFaible'
        ));
    }

    /**
     * Page Mouvements : historique complet avec filtres.
     */
    public function movements(Request $request)
    {
        $movements = StockMovement::with(['product', 'user', 'purchase'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $s = trim($request->q);
                $query->where(function ($w) use ($s) {
                    $w->where('motif', 'like', "%{$s}%")
                      ->orWhereHas('product', fn ($p) => $p
                          ->where('name', 'like', "%{$s}%")
                          ->orWhere('reference', 'like', "%{$s}%"));
                });
            })
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->when($request->filled('from'), fn ($q) => $q->whereDate('created_at', '>=', $request->from))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('created_at', '<=', $request->to))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('stock.movements', [
            'movements'     => $movements,
            'countAll'      => StockMovement::count(),
            'totalEntrees'  => StockMovement::where('type', 'entree')->sum('quantity'),
            'totalSorties'  => StockMovement::where('type', 'sortie')->sum('quantity'),
        ]);
    }

    /**
     * Enregistrer une SORTIE de stock.
     * (Les entrées passent par StockEntryController.)
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type' => ['required', 'in:sortie'],
            'quantity' => ['required', 'integer', 'min:1'],
            'motif' => ['nullable', 'string', 'max:255'],
            'observation' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($request) {

            $product = Product::lockForUpdate()
                ->findOrFail($request->product_id);

            $stockAvant = $product->quantity;

            if ($request->quantity > $stockAvant) {
                abort(422, 'Stock insuffisant pour effectuer cette sortie.');
            }

            $stockApres = $stockAvant - $request->quantity;

            $product->update([
                'quantity' => $stockApres,
            ]);

            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'type' => $request->type,
                'quantity' => $request->quantity,
                'stock_avant' => $stockAvant,
                'stock_apres' => $stockApres,
                'motif' => $request->motif,
                'observation' => $request->observation,
            ]);
        });

        return redirect()
            ->route('stock.movements.index')
            ->with('success', 'Sortie de stock enregistrée avec succès.');
    }
}