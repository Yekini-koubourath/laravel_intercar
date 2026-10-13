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
    // Validation des informations réellement présentes
    // dans le formulaire de création.
    $validated = $request->validate([

        // Informations générales
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

        'description' => [
            'nullable',
            'string',
        ],

        'type' => [
            'required',
            'in:vehicule,piece',
        ],

        // Informations du véhicule
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

        // Informations de la pièce détachée
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

        // Photos
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

    // La catégorie générale est renseignée automatiquement
    // à partir des informations déjà présentes dans le formulaire.
    if ($validated['type'] === 'vehicule') {
        $validated['category'] = 'vehicule';

        // Nettoyage des champs propres aux pièces.
        $validated['manufacturer_reference'] = null;
        $validated['piece_category'] = null;
        $validated['compatibility'] = null;
        $validated['piece_brand'] = null;
        $validated['condition_piece'] = null;
        $validated['warranty'] = null;
        $validated['unit'] = null;
    } else {
        $validated['category'] = $validated['piece_category'] ?? 'piece';

        // Nettoyage des champs propres aux véhicules.
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

    // Retirer les photos des données destinées au modèle Product.
    $images = $request->file('images', []);

    unset($validated['images']);

    // Initialiser les informations de tarification et de stock
    // sans demander de nouveaux champs dans le formulaire.
    $validated['selling_price'] = 0;
    $validated['purchase_price'] = null;
    $validated['quantity'] = 0;
    $validated['stock_minimum'] = 0;
    $validated['status'] = 'actif';

    // Créer le produit.
    $product = Product::create($validated);

    // Enregistrer les photos.
    foreach ($images as $index => $image) {
        $path = $image->store('products', 'public');

        $product->images()->create([
            'path' => $path,
            'original_name' => $image->getClientOriginalName(),
            'sort_order' => $index,
        ]);
    }

    return redirect()
        ->route('products.index')
        ->with('success', 'Produit ajouté avec succès.');
}
}