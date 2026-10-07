<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    protected $fillable = [
        'number',
        'sale_id',
        'user_id',
        'return_date',
        'total',
        'reason',
    ];

    protected $casts = [
        'return_date' => 'date',
        'total' => 'float',
    ];

    /**
     * Vente concernée.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Utilisateur ayant enregistré le retour.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Lignes du retour.
     */
    public function items()
    {
        return $this->hasMany(SaleReturnItem::class);
    }

    /**
     * Prochain numéro.
     *
     * Exemple :
     * RET-2026-0001
     */
    public static function nextNumber(): string
    {
        $prefix = 'RET-' . now()->year . '-';

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