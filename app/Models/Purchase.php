<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public const UNITS = [
        'piece' => 'Pièce',
        'kit'   => 'Kit',
        'lot'   => 'Lot',
        'paire' => 'Paire',
    ];

    public const CURRENCIES = [
        'XOF' => 'XOF — Franc CFA',
        'NGN' => 'NGN — Naira',
    ];

    public const EXPENSE_TYPES = [
        'transport'   => 'Transport',
        'douane'      => 'Douane',
        'manutention' => 'Manutention',
        'dossier'     => 'Frais de dossier',
        'assurance'   => 'Assurance',
        'autre'       => 'Autre',
    ];

    protected $fillable = [
        'number', 'purchase_date', 'supplier_id', 'supplier_reference',
        'product_id', 'user_id', 'stock_movement_id', 'exchange_rate_id',
        'quantity', 'unit', 'currency', 'unit_price',
        'exchange_rate', 'exchange_rate_source',
        'purchase_total_original', 'purchase_total_xof', 'expenses_total_xof',
        'total_cost_xof', 'unit_cost_xof',
        'selling_price', 'unit_margin', 'margin_percent', 'observation',
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];

    public function supplier()      { return $this->belongsTo(Supplier::class); }
    public function product()       { return $this->belongsTo(Product::class); }
    public function user()          { return $this->belongsTo(User::class); }
    public function stockMovement() { return $this->belongsTo(StockMovement::class); }
    public function expenses()      { return $this->hasMany(PurchaseExpense::class); }

    /** Marge totale sur l'entrée. */
    public function getTotalMarginAttribute(): float
    {
        return $this->unit_margin * $this->quantity;
    }

    /** Prochain numéro : ACH-2026-0001 */
    public static function nextNumber(): string
    {
        $prefix = 'ACH-' . now()->year . '-';

        $last = static::where('number', 'like', $prefix . '%')
            ->lockForUpdate()
            ->orderByDesc('number')
            ->value('number');

        $sequence = $last ? ((int) substr($last, strlen($prefix))) + 1 : 1;

        return $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}