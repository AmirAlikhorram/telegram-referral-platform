<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WalletTransactionFactory extends Factory
{
    public function definition(): array
    {
        return [

            'type' => 'reward',

            'amount' => 0,

            'balance_before' => 0,

            'balance_after' => 0,

            'status' => 'completed',

        ];
    }
}
