<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'usuario',
        'password',
        'role_id',
        'empresa_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // MUY IMPORTANTE: elimina cualquier $guarded = ['*']
    // NO debe existir esta línea:
    // protected $guarded = ['*'];

    public function getAuthIdentifierName()
    {
        return 'usuario';
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}

