<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Afficher la liste des produits.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();

        return view('products.index', compact('products'));
    }

    /**
     * Enregistrer un nouveau produit.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference' => ['required', 'string', 'max:255', 'unique:products,reference'],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:vehicule,piece'],
            'quantity' => ['required', 'integer', 'min:0'],
            'stock_minimum' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:actif,inactif'],
        ]);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produit ajouté avec succès.');
    }
}