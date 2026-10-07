<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'type',
        'quantity',
        'stock_avant',
        'stock_apres',
        'motif',
        'observation',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * L'achat (entrée de stock) qui a créé ce mouvement, s'il existe.
     */
    public function purchase()
    {
        return $this->hasOne(Purchase::class, 'stock_movement_id');
    }
}