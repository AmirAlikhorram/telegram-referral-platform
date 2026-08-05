<?php

namespace App\Services\Deposit;

use App\Jobs\ProcessReferralReward;
use App\Models\Deposit;
use App\Models\User;
use App\Services\Level\LevelService;
use App\Services\Telegram\NotificationService;
use App\Telegram\UI\Notifications\NotificationMessages;
use Illuminate\Support\Facades\DB;
use App\Services\Wallet\WalletService;


class DepositService
{
    public function __construct(
        private readonly LevelService $levelService,
        private readonly NotificationService $notificationService,
        private readonly WalletService $walletService,
    ) {
    }

    /**
     * ثبت درخواست واریز.
     */
    public function create(
        User $user,
        float $amount,
        string $network,
        string $txid,
        string $walletAddress,
    ): Deposit {

        return DB::transaction(function () use (
            $user,
            $amount,
            $network,
            $txid,
            $walletAddress,
        ) {

            return Deposit::create([
                'user_id'        => $user->id,
                'amount'         => $amount,
                'currency'       => 'USDT',
                'network'        => $network,
                'txid'           => $txid,
                'wallet_address' => $walletAddress,
                'status'         => 'pending',
            ]);
        });
    }

    /**
     * تایید واریز.
     */
    public function approve(
        Deposit $deposit,
        User $admin,
    ): Deposit {

        return DB::transaction(function () use ($deposit, $admin) {

            $deposit->update([
                'status'      => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => now(),
            ]);

            $user = $deposit->user;
            $this->walletService->deposit(
                $user,
                (string) $deposit->amount,
                'Deposit approved',
                Deposit::class,
                $deposit->id
            );

            $this->levelService->upgrade(
                $user,
                'professional'
            );

            $user->update([
                'activation_deposit_id'     => $deposit->id,
                'professional_activated_at' => now(),
                'withdraw_unlocked_at'      => now(),
            ]);

            /**
             * Notify User
             */
            $this->notificationService->send(
                $user,
                NotificationMessages::depositApproved($deposit)
            );

            /**
             * Referral Reward
             */
            /**
             * Referral Reward
             */
            ProcessReferralReward::dispatch($deposit);
            return $deposit->fresh();
        });
    }

    /**
     * رد درخواست واریز.
     */
    public function reject(
        Deposit $deposit,
        User $admin,
        ?string $reason = null,
    ): Deposit {

        return DB::transaction(function () use (
            $deposit,
            $admin,
            $reason,
        ) {

            $deposit->update([
                'status'      => 'rejected',
                'approved_by' => $admin->id,
                'approved_at' => now(),
                'admin_note'  => $reason,
            ]);

            /**
             * Notify User
             */
            $this->notificationService->send(
                $deposit->user,
                NotificationMessages::depositRejected(
                    $deposit,
                    $reason
                )
            );

            return $deposit->fresh();
        });
    }
}
