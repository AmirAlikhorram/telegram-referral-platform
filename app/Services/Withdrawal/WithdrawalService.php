<?php

namespace App\Services\Withdrawal;

use App\Models\User;
use App\Models\WithdrawalRequest;
use App\Services\Wallet\WalletService;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use App\Services\Telegram\NotificationService;
use App\Telegram\UI\Notifications\NotificationMessages;
use App\Jobs\NotifyAdminWithdrawalRequest;

class WithdrawalService
{
    public function __construct(
        private readonly WalletService $walletService,
        private readonly NotificationService $notificationService,
    ) {
    }

    /**
     * ثبت درخواست برداشت
     */
    public function create(
        User $user,
        float $amount,
        string $network,
        string $walletAddress,
    ): WithdrawalRequest {

        $this->validateWithdrawal($user, $amount);

        return DB::transaction(function () use (
            $user,
            $amount,
            $network,
            $walletAddress,
        ) {

            $this->walletService->lock(
                $user,
                $amount
            );

            $withdrawal = WithdrawalRequest::create([

                'user_id'        => $user->id,

                'amount'         => $amount,

                'currency'       => 'USDT',

                'network'        => $network,

                'wallet_address' => $walletAddress,

                'status'         => 'pending',

            ]);

            NotifyAdminWithdrawalRequest::dispatch(
                $withdrawal
            );

            return $withdrawal;
        });
    }
    /**
     * تایید درخواست برداشت
     */
    public function approve(
        WithdrawalRequest $withdrawal,
    ): WithdrawalRequest {

        if ($withdrawal->status !== 'pending') {
            return $withdrawal;
        }

        return DB::transaction(function () use ($withdrawal) {

            $withdrawal->update([
                'status'      => 'approved',
                'approved_at' => now(),
            ]);

            $this->notificationService->send(
                $withdrawal->user,
                NotificationMessages::withdrawApproved($withdrawal)
            );
            return $withdrawal->fresh();
        });
    }

    /**
     * رد درخواست برداشت
     */
    public function reject(
        WithdrawalRequest $withdrawal,
        ?string $note = null,
    ): WithdrawalRequest {

        if ($withdrawal->status !== 'pending') {
            return $withdrawal;
        }

        return DB::transaction(function () use (
            $withdrawal,
            $note,
        ) {

            $this->walletService->unlock(
                $withdrawal->user,
                $withdrawal->amount
            );

            $withdrawal->update([
                'status'     => 'rejected',
                'admin_note' => $note,
            ]);

            $this->notificationService->send(
                $withdrawal->user,
                NotificationMessages::withdrawRejected(
                    $withdrawal,
                    $note
                )
            );

            return $withdrawal->fresh();
        });
    }

    /**
     * ثبت پرداخت نهایی
     */
    public function markAsPaid(
        WithdrawalRequest $withdrawal,
    ): WithdrawalRequest {

        if ($withdrawal->status !== 'approved') {
            return $withdrawal;
        }

        return DB::transaction(function () use ($withdrawal) {

            $this->walletService->finalizeWithdrawal(
                $withdrawal->user,
                $withdrawal->amount,
                'Withdrawal Paid',
                WithdrawalRequest::class,
                $withdrawal->id,
            );

            $withdrawal->update([
                'status'  => 'paid',
                'paid_at' => now(),
            ]);

            $this->notificationService->send(
                $withdrawal->user,
                NotificationMessages::withdrawPaid($withdrawal)
            );

            return $withdrawal->fresh();
        });
    }

    /**
     * اعتبارسنجی درخواست برداشت
     */
    private function validateWithdrawal(
        User $user,
        float $amount,
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Check Level Exists
        |--------------------------------------------------------------------------
        */

        if (!$user->level) {

            throw new RuntimeException(
                'User level not found.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Starter Cannot Withdraw
        |--------------------------------------------------------------------------
        */

        if ($user->level->isStarter()) {

            throw new RuntimeException(
                'Withdrawal is not available for Starter level.'
            );

        }

        if (!$user->canWithdraw()) {

            throw new RuntimeException(
                'Withdrawal is not unlocked for this account.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Check Withdraw Permission
        |--------------------------------------------------------------------------
        */

        if (!$user->level->withdraw_enabled) {

            throw new RuntimeException(
                'Withdrawal is disabled for your current level.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Check Wallet Balance
        |--------------------------------------------------------------------------
        */

        $wallet = $this->walletService->wallet($user);


        if (
            bccomp(
                $wallet->withdrawable_balance,
                (string) $amount,
                8
            ) < 0
        ) {

            throw new RuntimeException(
                'Insufficient wallet balance.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Check Level Withdraw Limit
        |--------------------------------------------------------------------------
        */

        if (
            bccomp(
                (string) $amount,
                $user->level->withdraw_limit,
                8
            ) > 0
        ) {

            throw new RuntimeException(
                'Withdrawal amount exceeds your level limit.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Check Daily Withdraw Limit
        |--------------------------------------------------------------------------
        */

        if (
            bccomp(
                $user->level->daily_withdraw_limit,
                '0',
                8
            ) > 0
        ) {

            // فعلاً فقط placeholder است.
            // بعداً مجموع برداشت روزانه را محاسبه می‌کنیم.

        }

    }
}
