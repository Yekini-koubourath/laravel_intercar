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
     * Afficher le stock.
     */
    public function index()
    {
        $products = Product::orderBy('name')->get();

        $movements = StockMovement::with(['product', 'user'])
            ->latest()
            ->take(20)
            ->get();

        $totalProducts = $products->count();

        $totalStock = $products->sum('quantity');

        $stockFaible = $products->filter(function ($product) {
            return $product->quantity <= $product->stock_minimum;
        })->count();

        return view('stock.index', compact(
            'products',
            'movements',
            'totalProducts',
            'totalStock',
            'stockFaible'
        ));
    }

    /**
     * Enregistrer une entrée ou une sortie de stock.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type' => ['required', 'in:entree,sortie'],
            'quantity' => ['required', 'integer', 'min:1'],
            'motif' => ['nullable', 'string', 'max:255'],
            'observation' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($request) {

            $product = Product::lockForUpdate()
                ->findOrFail($request->product_id);

            $stockAvant = $product->quantity;

            if ($request->type === 'entree') {

                $stockApres = $stockAvant + $request->quantity;

            } else {

                if ($request->quantity > $stockAvant) {
                    abort(422, 'Stock insuffisant pour effectuer cette sortie.');
                }

                $stockApres = $stockAvant - $request->quantity;
            }

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
            ->route('stock.index')
            ->with('success', 'Mouvement de stock enregistré avec succès.');
    }
}