<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord.
     */
    public function index()
    {
        // =========================================================
        // PERIODES
        // =========================================================

        $today = now()->startOfDay();

        // Période actuelle : 7 derniers jours
        $currentStart = now()->copy()->subDays(6)->startOfDay();
        $currentEnd = now()->copy()->endOfDay();

        // Période précédente : les 7 jours avant
        $previousStart = now()->copy()->subDays(13)->startOfDay();
        $previousEnd = now()->copy()->subDays(7)->endOfDay();

        // =========================================================
        // VENTES
        // =========================================================

        $sales = Sale::with([
            'items.returnItems',
            'items.product',
            'returns.items',
        ])
            ->whereBetween('sale_date', [
                $previousStart->toDateString(),
                $currentEnd->toDateString(),
            ])
            ->get();

        // Ventes de la période actuelle
        $currentSales = $sales->filter(function ($sale) use ($currentStart, $currentEnd) {
            $date = Carbon::parse($sale->sale_date);

            return $date->between(
                $currentStart,
                $currentEnd
            );
        });

        // Ventes de la période précédente
        $previousSales = $sales->filter(function ($sale) use ($previousStart, $previousEnd) {
            $date = Carbon::parse($sale->sale_date);

            return $date->between(
                $previousStart,
                $previousEnd
            );
        });

        // =========================================================
        // CALCUL DU CHIFFRE D'AFFAIRES
        // =========================================================

        $currentRevenue = $this->calculateRevenue($currentSales);

        $previousRevenue = $this->calculateRevenue($previousSales);

        $revenueVariation = $this->calculateVariation(
            $currentRevenue,
            $previousRevenue
        );

        // =========================================================
        // CALCUL DES MARGES
        // =========================================================

        $currentMargin = $this->calculateMargin($currentSales);

        $previousMargin = $this->calculateMargin($previousSales);

        $marginVariation = $this->calculateVariation(
            $currentMargin,
            $previousMargin
        );

        // =========================================================
        // PRODUITS EN STOCK
        // =========================================================

        $activeProducts = Product::where('status', 'actif')->get();

        // Quantité totale réellement disponible
        $totalStock = (int) $activeProducts->sum('quantity');

        // Nombre de références actuellement en alerte
        $stockAlerts = $activeProducts->filter(function ($product) {
            return (int) $product->quantity <= (int) $product->stock_minimum;
        })->count();

        // Nombre de produits en rupture
        $stockOut = $activeProducts->filter(function ($product) {
            return (int) $product->quantity <= 0;
        })->count();

        // =========================================================
        // GRAPHIQUE DU CHIFFRE D'AFFAIRES - 7 JOURS
        // =========================================================

        $salesChart = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->copy()->subDays($i);

            $daySales = $currentSales->filter(function ($sale) use ($date) {
                return Carbon::parse($sale->sale_date)->isSameDay($date);
            });

            $salesChart->push([
                'date' => $date->format('d/m'),
                'label' => $date->translatedFormat('D'),
                'amount' => $this->calculateRevenue($daySales),
            ]);
        }

        // =========================================================
        // PRODUITS LES PLUS VENDUS
        // =========================================================

        $topProducts = $this->getTopProducts($currentSales);

        // =========================================================
        // ALERTES STOCK
        // =========================================================

        $stockAlertProducts = $activeProducts
            ->filter(function ($product) {
                return (int) $product->quantity <= (int) $product->stock_minimum;
            })
            ->sortBy(function ($product) {
                return (int) $product->quantity;
            })
            ->take(5);

        // =========================================================
        // TAUX DE CHANGE
        // =========================================================

        $exchangeRate = ExchangeRate::latestNgnXof();

        // =========================================================
        // RESUME DES MARGES
        // =========================================================

        $costOfSales = $this->calculateCostOfSales($currentSales);

        $marginRate = $currentRevenue > 0
            ? ($currentMargin / $currentRevenue) * 100
            : 0;

        // =========================================================
        // DONNEES ENVOYEES A LA VUE
        // =========================================================

        return view('dashboard', [
            // KPI
            'currentRevenue' => $currentRevenue,
            'previousRevenue' => $previousRevenue,
            'revenueVariation' => $revenueVariation,

            'currentMargin' => $currentMargin,
            'previousMargin' => $previousMargin,
            'marginVariation' => $marginVariation,

            'totalStock' => $totalStock,
            'stockAlerts' => $stockAlerts,
            'stockOut' => $stockOut,

            // Graphique
            'salesChart' => $salesChart,

            // Produits
            'topProducts' => $topProducts,
            'stockAlertProducts' => $stockAlertProducts,

            // Marge
            'costOfSales' => $costOfSales,
            'marginRate' => $marginRate,

            // Taux de change
            'exchangeRate' => $exchangeRate,

            // Période
            'periodLabel' => '7 derniers jours',
        ]);
    }

    /**
     * Calcule le chiffre d'affaires réel.
     *
     * Les retours sont déduits des ventes.
     */
    private function calculateRevenue(Collection $sales): float
    {
        $revenue = 0;

        foreach ($sales as $sale) {

            $subtotal = (float) $sale->items->sum('total');

            if ($subtotal <= 0) {
                continue;
            }

            // Montant total des produits retournés
            $returnedAmount = (float) $sale->returns->sum('total');

            // Sous-total réellement conservé
            $remainingSubtotal = max(
                0,
                $subtotal - $returnedAmount
            );

            // Répartition proportionnelle de la remise
            $discount = (float) $sale->discount;

            if ($subtotal > 0) {
                $effectiveDiscount = min(
                    $discount,
                    $discount * ($remainingSubtotal / $subtotal)
                );
            } else {
                $effectiveDiscount = 0;
            }

            $netRevenue = max(
                0,
                $remainingSubtotal - $effectiveDiscount
            );

            $revenue += $netRevenue;
        }

        return round($revenue, 2);
    }

    /**
     * Calcule la marge réelle après les retours et remises.
     */
    private function calculateMargin(Collection $sales): float
    {
        $margin = 0;

        foreach ($sales as $sale) {

            $subtotal = (float) $sale->items->sum('total');

            if ($subtotal <= 0) {
                continue;
            }

            $lineMargin = 0;

            foreach ($sale->items as $item) {

                $quantity = (int) $item->quantity;

                $returnedQuantity = (int) $item->returnItems->sum(
                    'quantity'
                );

                $remainingQuantity = max(
                    0,
                    $quantity - $returnedQuantity
                );

                $unitPrice = (float) $item->unit_price;
                $unitCost = (float) $item->unit_cost;

                $lineMargin += (
                    ($unitPrice - $unitCost)
                    * $remainingQuantity
                );
            }

            // Répartition proportionnelle de la remise
            $returnedAmount = (float) $sale->returns->sum('total');

            $remainingSubtotal = max(
                0,
                $subtotal - $returnedAmount
            );

            $discount = (float) $sale->discount;

            $effectiveDiscount = $subtotal > 0
                ? min(
                    $discount,
                    $discount * ($remainingSubtotal / $subtotal)
                )
                : 0;

            $margin += $lineMargin - $effectiveDiscount;
        }

        return round(max(0, $margin), 2);
    }

    /**
     * Calcule le coût des marchandises réellement vendues.
     */
    private function calculateCostOfSales(Collection $sales): float
    {
        $cost = 0;

        foreach ($sales as $sale) {

            foreach ($sale->items as $item) {

                $quantity = (int) $item->quantity;

                $returnedQuantity = (int) $item->returnItems->sum(
                    'quantity'
                );

                $remainingQuantity = max(
                    0,
                    $quantity - $returnedQuantity
                );

                $cost += (
                    (float) $item->unit_cost
                    * $remainingQuantity
                );
            }
        }

        return round($cost, 2);
    }

    /**
     * Calcule la variation entre deux périodes.
     */
    private function calculateVariation(
        float $current,
        float $previous
    ): float {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round(
            (($current - $previous) / $previous) * 100,
            1
        );
    }

    /**
     * Retourne les produits les plus vendus.
     */
    private function getTopProducts(Collection $sales): Collection
    {
        $products = collect();

        foreach ($sales as $sale) {

            foreach ($sale->items as $item) {

                if (!$item->product) {
                    continue;
                }

                $quantity = (int) $item->quantity;

                $returnedQuantity = (int) $item->returnItems->sum(
                    'quantity'
                );

                $remainingQuantity = max(
                    0,
                    $quantity - $returnedQuantity
                );

                if ($remainingQuantity <= 0) {
                    continue;
                }

                $productId = $item->product->id;

                if (!$products->has($productId)) {
                    $products->put($productId, [
                        'product' => $item->product,
                        'quantity' => 0,
                        'revenue' => 0,
                    ]);
                }

                $data = $products->get($productId);

                $data['quantity'] += $remainingQuantity;

                $data['revenue'] += (
                    $remainingQuantity
                    * (float) $item->unit_price
                );

                $products->put($productId, $data);
            }
        }

        return $products
            ->sortByDesc('quantity')
            ->take(5)
            ->values();
    }
}