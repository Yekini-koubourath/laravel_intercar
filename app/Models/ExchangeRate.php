<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $fillable = ['base_currency', 'target_currency', 'rate', 'source', 'rate_date'];

    protected $casts = [
        'rate' => 'float',
        'rate_date' => 'date',
    ];

    /** Dernier taux NGN -> XOF connu. */
    public static function latestNgnXof(): ?self
    {
        return static::where('base_currency', 'NGN')
            ->where('target_currency', 'XOF')
            ->orderByDesc('rate_date')
            ->orderByDesc('id')
            ->first();
    }

    /** Taux considéré non à jour après 2 jours. */
    public function isStale(): bool
    {
        return $this->rate_date->lt(now()->subDays(2)->startOfDay());
    }
}