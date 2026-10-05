<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'reference',
        'name',
        'category',
        'type',
        'quantity',
        'stock_minimum',
        'status',
    ];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}