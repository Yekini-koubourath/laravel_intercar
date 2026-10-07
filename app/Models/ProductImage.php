<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'path',
        'original_name',
        'sort_order',
    ];

    /**
     * Une image appartient à un produit.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}