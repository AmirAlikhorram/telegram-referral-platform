<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    protected $fillable = [

        'name',

        'slug',

        'priority',

        'activation_fee',

        'withdraw_enabled',

        'referral_levels',

        'withdraw_limit',

        'daily_withdraw_limit',

        'reward_multiplier',

        'is_active',

    ];

    protected function casts(): array
    {
        return [

            'activation_fee'       => 'decimal:8',

            'withdraw_limit'       => 'decimal:8',

            'daily_withdraw_limit' => 'decimal:8',

            'reward_multiplier'    => 'decimal:2',

            'withdraw_enabled'     => 'boolean',

            'is_active'            => 'boolean',

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isStarter(): bool
    {
        return $this->slug === 'starter';
    }

    public function isProfessional(): bool
    {
        return $this->slug === 'professional';
    }

    public function isVip(): bool
    {
        return $this->slug === 'vip';
    }
}
