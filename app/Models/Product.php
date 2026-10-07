<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'reference',
        'name',
        'brand',
        'category',
        'description',
        'type',
        'selling_price',
        'purchase_price',
        'quantity',
        'stock_minimum',
        'location',
        'status',

        // =====================================================
        // VEHICULE
        // =====================================================

        'vehicle_model',
        'vehicle_year',
        'fuel',
        'transmission',
        'mileage',
        'doors',
        'color',
        'condition',
        'availability',

        // =====================================================
        // PIECE
        // =====================================================

        'manufacturer_reference',
        'piece_category',
        'compatibility',
        'piece_brand',
        'condition_piece',
        'warranty',
        'unit',
    ];


    /**
     * Un produit possède plusieurs mouvements de stock.
     */
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }


    /**
     * Un produit possède plusieurs images.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class)
            ->orderBy('sort_order');
    }

    /**
 * Lignes de ventes liées à ce produit.
 */
public function saleItems()
{
    return $this->hasMany(SaleItem::class);
}
}