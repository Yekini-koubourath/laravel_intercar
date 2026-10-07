<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    /**
     * Liste des ventes.
     */
    public function index(Request $request)
    {
        $sales = Sale::with(['user'])
            ->withCount('items')
            ->when($request->filled('q'), function ($query) use ($request) {

                $search = trim($request->q);

                $query->where(function ($q) use ($search) {

                    $q->where('number', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_phone', 'like', "%{$search}%");

                });
            })
            ->when(
                $request->filled('status'),
                fn ($q) => $q->where('status', $request->status)
            )
            ->when(
                $request->filled('from'),
                fn ($q) => $q->whereDate(
                    'sale_date',
                    '>=',
                    $request->from
                )
            )
            ->when(
                $request->filled('to'),
                fn ($q) => $q->whereDate(
                    'sale_date',
                    '<=',
                    $request->to
                )
            )
            ->orderByDesc('sale_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('sales.index', [
            'sales' => $sales,
            'totalSales' => Sale::count(),
            'totalAmount' => Sale::where('status', '!=', 'annulee')
                ->sum('total'),
            'completedSales' => Sale::where('status', 'terminee')
                ->count(),
            'returnedSales' => Sale::whereIn('status', [
                'partiellement_retournee',
                'retournee',
            ])->count(),
        ]);
    }


    /**
     * Formulaire nouvelle vente.
     */
    public function create()
    {
        $products = Product::with('images')
            ->where('status', 'actif')
            ->where('quantity', '>', 0)
            ->orderBy('name')
            ->get();


        /*
         * Préparation des données destinées
         * au JavaScript de la page.
         */
        $productsData = $products->map(function ($product) {

            $image = $product->images->first();

            return [
                'id' => (int) $product->id,
                'name' => $product->name,
                'reference' => $product->reference,
                'quantity' => (int) $product->quantity,
                'selling_price' => (float) $product->selling_price,
                'image' => $image
                    ? route(
                        'product.image',
                        ['path' => $image->path]
                    )
                    : null,
            ];

        })->values()->all();


        return view('sales.create', [
            'products' => $products,
            'productsData' => $productsData,
            'nextNumber' => Sale::nextNumber(),
        ]);
    }


    /**
     * Enregistrer une nouvelle vente.
     */
    public function store(Request $request)
    {
        $data = $request->validate([

            'sale_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'customer_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'customer_phone' => [
                'nullable',
                'string',
                'max:50',
            ],

            'payment_method' => [
                'required',
                'in:especes,mobile_money,virement,carte,autre',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'observation' => [
                'nullable',
                'string',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.product_id' => [
                'required',
                'exists:products,id',
                'distinct',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.unit_price' => [
                'required',
                'numeric',
                'min:0',
            ],

        ], [

            'sale_date.before_or_equal' =>
                'La date de vente ne peut pas être dans le futur.',

            'items.required' =>
                'Veuillez ajouter au moins un produit.',

            'items.min' =>
                'Veuillez ajouter au moins un produit.',

            'items.*.product_id.distinct' =>
                'Un même produit ne peut pas apparaître plusieurs fois dans la vente.',

            'items.*.unit_price.required' =>
                'Le prix unitaire est obligatoire.',

            'items.*.unit_price.numeric' =>
                'Le prix unitaire doit être un nombre.',

        ]);


        $sale = DB::transaction(function () use ($data) {

            $items = $data['items'];

            $discount = (float) ($data['discount'] ?? 0);


            /*
             * Création de la vente.
             */
            $sale = Sale::create([

                'number' => Sale::nextNumber(),

                'sale_date' => $data['sale_date'],

                'customer_name' =>
                    $data['customer_name'] ?? null,

                'customer_phone' =>
                    $data['customer_phone'] ?? null,

                'user_id' =>
                    Auth::id(),

                'payment_method' =>
                    $data['payment_method'],

                'subtotal' => 0,

                'discount' =>
                    $discount,

                'total' => 0,

                'status' =>
                    'terminee',

                'observation' =>
                    $data['observation'] ?? null,

            ]);


            $subtotal = 0;


            /*
             * Parcours des produits.
             */
            foreach ($items as $itemData) {

                /*
                 * Verrouillage du produit.
                 */
                $product = Product::lockForUpdate()
                    ->findOrFail(
                        $itemData['product_id']
                    );


                $quantity =
                    (int) $itemData['quantity'];


                /*
                 * Vérification du stock.
                 */
                if (
                    $quantity >
                    $product->quantity
                ) {

                    abort(
                        422,
                        "Stock insuffisant pour {$product->name}. Stock disponible : {$product->quantity}."
                    );

                }


                /*
                 * Prix réellement utilisé
                 * pour cette vente.
                 */
                $unitPrice =
                    (float) $itemData['unit_price'];


                /*
                 * Prix de revient.
                 */
                $unitCost =
                    (float) (
                        $product->purchase_price ?? 0
                    );


                /*
                 * Total de la ligne.
                 */
                $lineTotal =
                    $unitPrice * $quantity;


                /*
                 * Stock avant.
                 */
                $stockAvant =
                    (int) $product->quantity;


                /*
                 * Stock après.
                 */
                $stockApres =
                    $stockAvant - $quantity;


                /*
                 * Création de la ligne de vente.
                 */
                SaleItem::create([

                    'sale_id' =>
                        $sale->id,

                    'product_id' =>
                        $product->id,

                    'quantity' =>
                        $quantity,

                    'unit_price' =>
                        $unitPrice,

                    'unit_cost' =>
                        $unitCost,

                    'total' =>
                        $lineTotal,

                ]);


                /*
                 * Mise à jour du stock.
                 */
                $product->update([

                    'quantity' =>
                        $stockApres,

                ]);


                /*
                 * Si c'est un véhicule et qu'il
                 * n'y en a plus en stock, on le marque vendu.
                 */
                if (
                    $product->type === 'vehicule' &&
                    $stockApres <= 0
                ) {

                    $product->update([
                        'availability' => 'vendu',
                    ]);

                }


                /*
                 * Création automatique du mouvement
                 * de sortie de stock.
                 */
                StockMovement::create([

                    'product_id' =>
                        $product->id,

                    'user_id' =>
                        Auth::id(),

                    'type' =>
                        'sortie',

                    'quantity' =>
                        $quantity,

                    'stock_avant' =>
                        $stockAvant,

                    'stock_apres' =>
                        $stockApres,

                    'motif' =>
                        Str::limit(
                            'Vente ' . $sale->number,
                            250,
                            ''
                        ),

                    'observation' =>
                        $data['observation'] ?? null,

                ]);


                $subtotal +=
                    $lineTotal;
            }


            /*
             * Le total ne peut jamais être négatif.
             */
            $total =
                max(
                    0,
                    $subtotal - $discount
                );


            /*
             * Mise à jour des totaux.
             */
            $sale->update([

                'subtotal' =>
                    $subtotal,

                'total' =>
                    $total,

            ]);


            return $sale;
        });


        return redirect()
            ->route(
                'sales.show',
                $sale
            )
            ->with(
                'success',
                "Vente {$sale->number} enregistrée avec succès. Le stock a été mis à jour."
            );
    }


    /**
     * Détail d'une vente.
     */
    public function show(Sale $sale)
    {
        $sale->load([

            'user',

            'items.product',

            'returns.user',

            'returns.items.product',

        ]);


        return view('sales.show', [

            'sale' =>
                $sale,

        ]);
    }
}