<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralRewardLevel extends Model
{
    protected $fillable = [

        'level',

        'percent',

        'is_active',

    ];

    protected function casts(): array
    {
        return [

            'percent' => 'decimal:2',

            'is_active' => 'boolean',

        ];
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
}
