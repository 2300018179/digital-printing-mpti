<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'phone'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // PERBAIKAN: Ganti Order::class menjadi Pesanan::class
    public function pesanan(): HasMany
    {
        // Sesuaikan 'user_id' jika nama kolom foreign key Anda berbeda
        return $this->hasMany(Pesanan::class, 'user_id');
    }

    public function keranjangs()
    {
        return $this->hasMany(\App\Models\Keranjang::class, 'user_id');
    }
}