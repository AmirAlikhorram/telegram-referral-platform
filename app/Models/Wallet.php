<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    protected $fillable = [

        'user_id',

        'reward_balance',

        'withdrawable_balance',

        'locked_balance',

        'total_earned',

        'total_withdrawn',

    ];

    protected function casts(): array
    {
        return [

            'reward_balance' => 'decimal:8',

            'withdrawable_balance' => 'decimal:8',

            'locked_balance' => 'decimal:8',

            'total_earned' => 'decimal:8',

            'total_withdrawn' => 'decimal:8',

        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function getBalanceAttribute(): string
    {
        return $this->withdrawable_balance;
    }
}
