<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    protected $fillable = [

        'wallet_id',

        'type',

        'amount',

        'balance_before',

        'balance_after',

        'reference_type',

        'reference_id',

        'description',

        'status',

    ];

    protected function casts(): array
    {
        return [

            'amount' => 'decimal:8',

            'balance_before' => 'decimal:8',

            'balance_after' => 'decimal:8',

        ];
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function reference()
    {
        return $this->morphTo();
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
