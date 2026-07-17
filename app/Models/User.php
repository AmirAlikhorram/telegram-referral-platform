<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'telegram_id',
        'telegram_username',
        'first_name',
        'last_name',
        'referral_code',
        'referred_by_user_id',
        'status',
        'telegram_joined_at',
        'is_admin',
    ];

    protected function casts(): array
    {
        return [
            'telegram_joined_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
