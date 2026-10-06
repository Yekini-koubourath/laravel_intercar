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

        // Véhicule
        'vehicle_model',
        'vehicle_year',
        'fuel',
        'transmission',
        'mileage',
        'doors',
        'color',
        'condition',
        'availability',

        // Pièce
        'manufacturer_reference',
        'piece_category',
        'compatibility',
        'piece_brand',
        'condition_piece',
        'warranty',
        'unit',
    ];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}