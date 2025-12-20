<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'company_id',
        'user_id',
        'amount',
        'currency',
        'payment_method',
        'status',
        'reference',
        'paid_at',
    ];

    // Un pago pertenece a una empresa
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Un pago puede pertenecer a un usuario (opcional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un pago tiene muchos items
    public function items()
    {
        return $this->hasMany(PaymentItem::class);
    }
}
