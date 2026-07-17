<?php

namespace App\Services\Wallet;

use App\Models\User;

//class WalletService
//{
//    /**
//     * افزایش موجودی کاربر
//     */
//    public function deposit(User $user, float $amount): void
//    {
//        $user->increment('wallet_balance', $amount);
//    }
//
//    /**
//     * کاهش موجودی کاربر
//     */
//    public function withdraw(User $user, float $amount): bool
//    {
//        if ($user->wallet_balance < $amount) {
//            return false;
//        }
//
//        $user->decrement('wallet_balance', $amount);
//
//        return true;
//    }
//
//    /**
//     * موجودی کیف پول
//     */
//    public function balance(User $user): float
//    {
//        return (float) $user->wallet_balance;
//    }
//}


class WalletService
{
    public function __construct(
        private WalletTransactionService $transactionService,
    )
    {
    }

    /**
     * واریز
     */
    public function deposit(
        User    $user,
        float   $amount,
        ?string $description = null,
    ): void
    {

        $user->increment('wallet_balance', $amount);

        $this->transactionService->create(
            $user,
            'deposit',
            $amount,
            $description
        );
    }

    /**
     * برداشت
     */
    public function withdraw(
        User    $user,
        float   $amount,
        ?string $description = null,
    ): bool
    {

        if ($user->wallet_balance < $amount) {
            return false;
        }

        $user->decrement('wallet_balance', $amount);

        $this->transactionService->create(
            $user,
            'withdraw',
            $amount,
            $description
        );

        return true;
    }

    /**
     * موجودی
     */
    public function balance(User $user): float
    {
        return (float)$user->wallet_balance;
    }
}
