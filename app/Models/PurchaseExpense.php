<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseExpense extends Model
{
    protected $fillable = [
        'purchase_id', 'type', 'description', 'amount', 'currency', 'amount_xof',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}