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
        $products = Product::with('images')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('products.index', compact('products'));
    }


    /**
     * Enregistrer un nouveau produit.
     */
    public function store(Request $request)
    {
        // =========================================================
        // VALIDATION
        // =========================================================

        $validated = $request->validate([

            // =====================================================
            // INFORMATIONS COMMUNES
            // =====================================================

            'reference' => [
                'required',
                'string',
                'max:255',
                'unique:products,reference',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'brand' => [
                'required',
                'string',
                'max:255',
            ],

            'category' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'type' => [
                'required',
                'in:vehicule,piece',
            ],


            // =====================================================
            // PRIX
            // =====================================================

            'selling_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'purchase_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],


            // =====================================================
            // STOCK
            // =====================================================

            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'stock_minimum' => [
                'required',
                'integer',
                'min:0',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],


            // =====================================================
            // STATUT
            // =====================================================

            'status' => [
                'required',
                'in:actif,inactif,brouillon',
            ],


            // =====================================================
            // VEHICULE
            // =====================================================

            'vehicle_model' => [
                'nullable',
                'string',
                'max:255',
            ],

            'vehicle_year' => [
                'nullable',
                'integer',
                'min:1980',
                'max:' . date('Y'),
            ],

            'fuel' => [
                'nullable',
                'in:essence,diesel,hybride,electrique',
            ],

            'transmission' => [
                'nullable',
                'in:manuelle,automatique,cvt',
            ],

            'mileage' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'doors' => [
                'nullable',
                'integer',
                'min:2',
                'max:5',
            ],

            'color' => [
                'nullable',
                'string',
                'max:100',
            ],

            'condition' => [
                'nullable',
                'in:neuf,occasion,reconditionne',
            ],

            'availability' => [
                'nullable',
                'in:disponible,reserve,vendu',
            ],


            // =====================================================
            // PIECE DETACHEE
            // =====================================================

            'manufacturer_reference' => [
                'nullable',
                'string',
                'max:255',
            ],

            'piece_category' => [
                'nullable',
                'string',
                'max:255',
            ],

            'compatibility' => [
                'nullable',
                'string',
            ],

            'piece_brand' => [
                'nullable',
                'string',
                'max:255',
            ],

            'condition_piece' => [
                'nullable',
                'in:neuf,occasion,reconditionne',
            ],

            'warranty' => [
                'nullable',
                'in:sans,3_mois,6_mois,12_mois,24_mois',
            ],

            'unit' => [
                'nullable',
                'in:piece,kit,lot,paire',
            ],


            // =====================================================
            // PHOTOS
            // =====================================================

            'images' => [
                'nullable',
                'array',
            ],

            'images.*' => [
                'nullable',
                'image',
                'mimes:jpeg,png,webp',
                'max:5120',
            ],
        ]);


        // =========================================================
        // NETTOYAGE DES CHAMPS SELON LE TYPE
        // =========================================================

        if ($validated['type'] === 'vehicule') {

            // Une voiture ne doit pas avoir les informations
            // spécifiques à une pièce.

            $validated['manufacturer_reference'] = null;
            $validated['piece_category'] = null;
            $validated['compatibility'] = null;
            $validated['piece_brand'] = null;
            $validated['condition_piece'] = null;
            $validated['warranty'] = null;
            $validated['unit'] = null;

        } else {

            // Une pièce ne doit pas avoir les informations
            // spécifiques à un véhicule.

            $validated['vehicle_model'] = null;
            $validated['vehicle_year'] = null;
            $validated['fuel'] = null;
            $validated['transmission'] = null;
            $validated['mileage'] = null;
            $validated['doors'] = null;
            $validated['color'] = null;
            $validated['condition'] = null;
            $validated['availability'] = null;
        }


        // =========================================================
        // RECUPERATION DES IMAGES
        // =========================================================

        $images = $request->file('images', []);


        // =========================================================
        // CREATION DU PRODUIT
        // =========================================================

        $product = Product::create($validated);


        // =========================================================
        // ENREGISTREMENT DES IMAGES
        // =========================================================

        foreach ($images as $index => $image) {

            $path = $image->store(
                'products',
                'public'
            );

            $product->images()->create([
                'path' => $path,
                'original_name' => $image->getClientOriginalName(),
                'sort_order' => $index,
            ]);
        }


        // =========================================================
        // REDIRECTION
        // =========================================================

        return redirect()
            ->route('products.index')
            ->with('success', 'Produit ajouté avec succès.');
    }
}