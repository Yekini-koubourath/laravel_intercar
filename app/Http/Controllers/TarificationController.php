<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class TarificationController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        // Une seule requête de base pour le filtrage.
        $query = Product::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('reference', 'like', '%' . $search . '%');
                });
            });

        // Les totaux concernent tous les produits filtrés,
        // pas uniquement ceux de la page de pagination actuelle.
        $totalCost = (clone $query)->sum('purchase_price');
        $totalSale = (clone $query)->sum('selling_price');
        $totalMargin = $totalSale - $totalCost;

        // Liste paginée.
        $products = (clone $query)
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('tarification.index', compact(
            'products',
            'search',
            'totalCost',
            'totalSale',
            'totalMargin'
        ));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'selling_price' => ['required', 'numeric', 'min:0'],
        ], [
            'selling_price.required' => 'Le prix de vente est obligatoire.',
            'selling_price.numeric' => 'Le prix de vente doit être un nombre valide.',
            'selling_price.min' => 'Le prix de vente ne peut pas être négatif.',
        ]);

        $product->update([
            'selling_price' => $data['selling_price'],
        ]);

        return redirect()
            ->route('tarification.index', [
                'q' => $request->input('q', ''),
                'page' => $request->input('page', 1),
            ])
            ->with('success', 'Le prix de vente a été mis à jour avec succès.');
    }
}
