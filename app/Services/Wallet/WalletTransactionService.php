<?php

namespace App\Services\Wallet;

use App\Models\User;
use App\Models\WalletTransaction;

class WalletTransactionService
{
    /**
     * ثبت تراکنش
     */
    public function create(
        User $user,
        string $type,
        float $amount,
        ?string $description = null,
    ): WalletTransaction {

        return WalletTransaction::create([
            'user_id' => $user->id,
            'type' => $type,
            'amount' => $amount,
            'description' => $description,
        ]);
    }
}
