<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentItem extends Model
{
    protected $fillable = [
        'payment_id',
        'item_type',
        'item_id',
        'amount',
    ];

    // Un item pertenece a un pago
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function item()
    {
        return $this->morphTo();
    }
}
