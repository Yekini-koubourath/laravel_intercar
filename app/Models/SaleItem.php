<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'unit_cost',
        'total',
    ];

    protected $casts = [
        'unit_price' => 'float',
        'unit_cost' => 'float',
        'total' => 'float',
    ];

    /**
     * Vente.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Produit.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Retours effectués sur cette ligne.
     */
    public function returnItems()
    {
        return $this->hasMany(SaleReturnItem::class);
    }

    /**
     * Quantité déjà retournée.
     */
    public function getReturnedQuantityAttribute(): int
    {
        return (int) $this->returnItems()->sum('quantity');
    }

    /**
     * Quantité encore retournable.
     */
    public function getRemainingQuantityAttribute(): int
    {
        return max(
            0,
            $this->quantity - $this->returned_quantity
        );
    }
}