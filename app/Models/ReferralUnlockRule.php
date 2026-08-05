<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferralUnlockRule extends Model
{
    protected $fillable = [

        'level_id',

        'threshold_amount',

        'unlock_percent',

        'is_active',

    ];


    protected function casts(): array
    {
        return [

            'threshold_amount' => 'decimal:8',

            'unlock_percent' => 'decimal:2',

            'is_active' => 'boolean',

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */


    public function level(): BelongsTo
    {
        return $this->belongsTo(
            Level::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */


    public function isEnabled(): bool
    {
        return $this->is_active;
    }


    public function canUnlock(
        string $rewardBalance
    ): bool {

        return bccomp(
                $rewardBalance,
                $this->threshold_amount,
                8
            ) >= 0;

    }


    public function unlockAmount(
        string $rewardBalance
    ): string {

        return bcmul(
            $rewardBalance,
            bcdiv(
                $this->unlock_percent,
                '100',
                8
            ),
            8
        );

    }
}
