<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $fillable = [
        'base_currency',
        'target_currency',
        'rate',
        'source',
        'rate_date',
    ];

    protected $casts = [
        'rate' => 'float',
        'rate_date' => 'date',
    ];

    /**
     * Récupère le dernier taux connu d'une devise vers le XOF.
     *
     * Exemples :
     * NGN -> XOF
     * EUR -> XOF
     * USD -> XOF
     */
    public static function latestToXof(string $currency): ?self
    {
        $currency = strtoupper(trim($currency));

        if (! in_array($currency, ['NGN', 'EUR', 'USD'], true)) {
            return null;
        }

        return static::where('base_currency', $currency)
            ->where('target_currency', 'XOF')
            ->orderByDesc('rate_date')
            ->orderByDesc('id')
            ->first();
    }

    /**
     * Dernier taux NGN -> XOF connu.
     * Conservé pour la compatibilité avec le code existant.
     */
    public static function latestNgnXof(): ?self
    {
        return static::latestToXof('NGN');
    }

    /**
     * Indique si le taux date de plus de deux jours.
     */
    public function isStale(): bool
    {
        return $this->rate_date->lt(
            now()->subDays(2)->startOfDay()
        );
    }
}