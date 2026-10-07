<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'number',
        'sale_date',
        'customer_name',
        'customer_phone',
        'user_id',
        'payment_method',
        'subtotal',
        'discount',
        'total',
        'status',
        'observation',
    ];

    protected $casts = [
        'sale_date' => 'date',
        'subtotal' => 'float',
        'discount' => 'float',
        'total' => 'float',
    ];

    /**
     * Utilisateur ayant créé la vente.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Produits/lignes de la vente.
     */
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Retours liés à cette vente.
     */
    public function returns()
    {
        return $this->hasMany(SaleReturn::class);
    }

    /**
     * Prochain numéro de vente.
     *
     * Exemple :
     * VEN-2026-0001
     */
    public static function nextNumber(): string
    {
        $prefix = 'VEN-' . now()->year . '-';

        $last = static::where('number', 'like', $prefix . '%')
            ->orderByDesc('number')
            ->value('number');

        $sequence = $last
            ? ((int) substr($last, strlen($prefix))) + 1
            : 1;

        return $prefix . str_pad(
            $sequence,
            4,
            '0',
            STR_PAD_LEFT
        );
    }
}