<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens; // ✅ Required for Sanctum
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // ✅ This line enables API tokens

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'location',
        'role',
        'image'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
}
