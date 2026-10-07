<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\SaleReturnItem;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SaleReturnController extends Controller
{
    /**
     * Liste des retours.
     */
    public function index(Request $request)
    {
        $returns = SaleReturn::with([
            'sale',
            'user',
        ])
            ->when($request->filled('q'), function ($query) use ($request) {

                $search = trim($request->q);

                $query->where(function ($q) use ($search) {

                    $q->where('number', 'like', "%{$search}%")
                        ->orWhere('reason', 'like', "%{$search}%")
                        ->orWhereHas('sale', function ($sale) use ($search) {

                            $sale->where(
                                'number',
                                'like',
                                "%{$search}%"
                            )->orWhere(
                                'customer_name',
                                'like',
                                "%{$search}%"
                            );

                        });

                });
            })
            ->orderByDesc('return_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('sales.returns.index', [
            'returns' => $returns,
            'totalReturns' => SaleReturn::count(),
            'totalAmount' => SaleReturn::sum('total'),
        ]);
    }


    /**
     * Formulaire de retour.
     */
    public function create()
    {
        $sales = Sale::with([
            'items.product',
        ])
            ->whereIn('status', [
                'terminee',
                'partiellement_retournee',
            ])
            ->orderByDesc('sale_date')
            ->orderByDesc('id')
            ->get();

        return view('sales.returns.create', [
            'sales' => $sales,
            'nextNumber' => SaleReturn::nextNumber(),
        ]);
    }


    /**
     * Enregistrer un retour.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'sale_id' => [
                'required',
                'exists:sales,id',
            ],

            'return_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'reason' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.sale_item_id' => [
                'required',
                'exists:sale_items,id',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ], [
            'return_date.before_or_equal' =>
                'La date du retour ne peut pas être dans le futur.',

            'items.required' =>
                'Veuillez sélectionner au moins un produit à retourner.',

            'items.min' =>
                'Veuillez sélectionner au moins un produit à retourner.',
        ]);


        $return = DB::transaction(function () use ($data) {

            $sale = Sale::lockForUpdate()
                ->with('items')
                ->findOrFail($data['sale_id']);


            /*
             * Création du retour.
             */
            $saleReturn = SaleReturn::create([
                'number' => SaleReturn::nextNumber(),
                'sale_id' => $sale->id,
                'user_id' => Auth::id(),
                'return_date' => $data['return_date'],
                'total' => 0,
                'reason' => $data['reason'] ?? null,
            ]);


            $returnTotal = 0;


            foreach ($data['items'] as $itemData) {

                $saleItem = $sale->items()
                    ->lockForUpdate()
                    ->findOrFail($itemData['sale_item_id']);


                /*
                 * Vérifier que la ligne appartient bien
                 * à la vente sélectionnée.
                 */
                if ($saleItem->sale_id !== $sale->id) {

                    abort(
                        422,
                        'Une ligne sélectionnée ne correspond pas à cette vente.'
                    );
                }


                /*
                 * Quantité déjà retournée.
                 */
                $alreadyReturned = SaleReturnItem::where(
                    'sale_item_id',
                    $saleItem->id
                )->sum('quantity');


                $remaining = $saleItem->quantity - $alreadyReturned;

                $quantity = (int) $itemData['quantity'];


                /*
                 * Impossible de retourner plus
                 * que la quantité restante.
                 */
                if ($quantity > $remaining) {

                    abort(
                        422,
                        "La quantité retournée pour {$saleItem->product->name} dépasse la quantité disponible pour retour."
                    );
                }


                /*
                 * Verrouillage du produit.
                 */
                $product = $saleItem->product()
                    ->lockForUpdate()
                    ->firstOrFail();


                $stockAvant = $product->quantity;

                $stockApres = $stockAvant + $quantity;


                /*
                 * Montant du retour.
                 */
                $lineTotal = $saleItem->unit_price * $quantity;


                /*
                 * Création de la ligne de retour.
                 */
                SaleReturnItem::create([
                    'sale_return_id' => $saleReturn->id,
                    'sale_item_id' => $saleItem->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $saleItem->unit_price,
                    'total' => $lineTotal,
                ]);


                /*
                 * Réintégration du produit dans le stock.
                 */
                $product->update([
                    'quantity' => $stockApres,
                ]);


                /*
                 * Création automatique d'une entrée
                 * de stock pour le retour.
                 */
                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => Auth::id(),
                    'type' => 'entree',
                    'quantity' => $quantity,
                    'stock_avant' => $stockAvant,
                    'stock_apres' => $stockApres,
                    'motif' => Str::limit(
                        'Retour ' . $saleReturn->number .
                        ' - vente ' . $sale->number,
                        250,
                        ''
                    ),
                    'observation' => $data['reason'] ?? null,
                ]);


                $returnTotal += $lineTotal;
            }


            /*
             * Enregistrement du montant total.
             */
            $saleReturn->update([
                'total' => $returnTotal,
            ]);


            /*
             * Vérification du statut de la vente.
             */
            $totalSold = $sale->items->sum('quantity');

            $totalReturned = SaleReturnItem::whereIn(
                'sale_item_id',
                $sale->items->pluck('id')
            )->sum('quantity');


            if ($totalReturned >= $totalSold) {

                $sale->update([
                    'status' => 'retournee',
                ]);

            } else {

                $sale->update([
                    'status' => 'partiellement_retournee',
                ]);
            }


            return $saleReturn;
        });


        return redirect()
            ->route('sales.returns.index')
            ->with(
                'success',
                "Retour {$return->number} enregistré avec succès. Le stock a été réintégré."
            );
    }


    /**
     * Afficher le détail d'un retour.
     */
    public function show(SaleReturn $return)
    {
        $return->load([
            'sale',
            'user',
            'items.product',
        ]);

        return view('sales.returns.show', [
            'return' => $return,
        ]);
    }
}