<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    public function cancha()
    {
        return $this->belongsTo(Cancha::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pago()
    {
        return $this->hasOne(Pago::class);
    }

    // Relación con payment_items (polimórfica)
    public function paymentItem()
    {
        return $this->morphOne(PaymentItem::class, 'item');
    }
}
