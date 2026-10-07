<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleReturnItem extends Model
{
    protected $fillable = [
        'sale_return_id',
        'sale_item_id',
        'product_id',
        'quantity',
        'unit_price',
        'total',
    ];

    protected $casts = [
        'unit_price' => 'float',
        'total' => 'float',
    ];

    /**
     * Retour.
     */
    public function saleReturn()
    {
        return $this->belongsTo(
            SaleReturn::class,
            'sale_return_id'
        );
    }

    /**
     * Ligne de vente.
     */
    public function saleItem()
    {
        return $this->belongsTo(SaleItem::class);
    }

    /**
     * Produit.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}