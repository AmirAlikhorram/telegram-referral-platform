<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    public function definition(): array
    {
        return [

            'reward_balance' => 0,

            'withdrawable_balance' => 0,

            'locked_balance' => 0,

            'total_earned' => 0,

            'total_withdrawn' => 0,

        ];
    }
}
