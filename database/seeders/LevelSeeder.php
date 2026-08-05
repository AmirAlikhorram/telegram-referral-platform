<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        Level::updateOrCreate(
            ['slug' => 'starter'],
            [
                'name' => 'Starter',
                'priority' => 1,
                'activation_fee' => 0,
                'withdraw_enabled' => false,
                'referral_levels' => 1,
                'withdraw_limit' => 0,
                'daily_withdraw_limit' => 0,
                'reward_multiplier' => 1,
                'is_active' => true,
            ]
        );

        Level::updateOrCreate(
            ['slug' => 'professional'],
            [
                'name' => 'Professional',
                'priority' => 2,
                'activation_fee' => 10,
                'withdraw_enabled' => true,
                'referral_levels' => 5,
                'withdraw_limit' => 500,
                'daily_withdraw_limit' => 1000,
                'reward_multiplier' => 1.20,
                'is_active' => true,
            ]
        );
    }
}
