<?php

namespace App\Services\Wallet;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class WalletService
{
    public function wallet(User $user): Wallet
    {
        return $user->wallet()->firstOrCreate(
            [],
            [
                'reward_balance'       => '0',
                'withdrawable_balance' => '0',
                'locked_balance'       => '0',
                'total_earned'         => '0',
                'total_withdrawn'      => '0',
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Deposit
    |--------------------------------------------------------------------------
    */

    public function deposit(
        User $user,
        string $amount,
        string $description,
        ?string $referenceType = null,
        ?int $referenceId = null,
    ): Wallet {

        return DB::transaction(function () use (
            $user,
            $amount,
            $description,
            $referenceType,
            $referenceId
        ) {

            $wallet = $this->wallet($user);

            $before = $wallet->withdrawable_balance;

            $after = bcadd($before, $amount, 8);

            $wallet->update([
                'withdrawable_balance' => $after,
            ]);

            $this->storeTransaction(
                $wallet,
                'deposit',
                $amount,
                $before,
                $after,
                $description,
                $referenceType,
                $referenceId,
            );

            return $wallet->fresh();

        });

    }

    /*
    |--------------------------------------------------------------------------
    | Reward
    |--------------------------------------------------------------------------
    */

    public function reward(
        User $user,
        string $amount,
        string $description,
        ?string $referenceType = null,
        ?int $referenceId = null,
    ): Wallet {

        return DB::transaction(function () use (
            $user,
            $amount,
            $description,
            $referenceType,
            $referenceId
        ) {

            $wallet = $this->wallet($user);

            $before = $wallet->reward_balance;

            $after = bcadd($before, $amount, 8);

            $wallet->update([

                'reward_balance' => $after,

                'total_earned' => bcadd(
                    $wallet->total_earned,
                    $amount,
                    8
                ),

            ]);

            $this->storeTransaction(
                $wallet,
                'reward',
                $amount,
                $before,
                $after,
                $description,
                $referenceType,
                $referenceId,
            );

            return $wallet->fresh();

        });

    }

    /*
    |--------------------------------------------------------------------------
    | Unlock Referral Reward
    |--------------------------------------------------------------------------
    */

    public function unlockReferralReward(
        User $user,
        string $amount
    ): Wallet {

        return DB::transaction(function () use ($user, $amount) {

            $wallet = $this->wallet($user);

            if (
                bccomp(
                    $wallet->reward_balance,
                    $amount,
                    8
                ) < 0
            ) {
                throw new RuntimeException(
                    'Insufficient reward balance.'
                );
            }

            $rewardBefore = $wallet->reward_balance;

            $rewardAfter = bcsub(
                $rewardBefore,
                $amount,
                8
            );

            $withdrawBefore = $wallet->withdrawable_balance;

            $withdrawAfter = bcadd(
                $withdrawBefore,
                $amount,
                8
            );

            $wallet->update([

                'reward_balance' => $rewardAfter,

                'withdrawable_balance' => $withdrawAfter,

            ]);

            WalletTransaction::create([

                'wallet_id' => $wallet->id,

                'type' => 'unlock',

                'amount' => $amount,

                'balance_before' => $rewardBefore,

                'balance_after' => $rewardAfter,

                'description' => 'Referral reward unlocked',

                'status' => 'completed',

            ]);

            return $wallet->fresh();

        });

    }

    /*
|--------------------------------------------------------------------------
| Lock
|--------------------------------------------------------------------------
*/

    public function lock(
        User $user,
        string $amount
    ): Wallet {

        return DB::transaction(function () use ($user, $amount) {

            $wallet = $this->wallet($user);

            if (
                bccomp(
                    $wallet->withdrawable_balance,
                    $amount,
                    8
                ) < 0
            ) {
                throw new RuntimeException(
                    'Insufficient withdrawable balance.'
                );
            }

            $before = $wallet->withdrawable_balance;

            $after = bcsub(
                $wallet->withdrawable_balance,
                $amount,
                8
            );

            $wallet->update([

                'withdrawable_balance' => $after,

                'locked_balance' => bcadd(
                    $wallet->locked_balance,
                    $amount,
                    8
                ),

            ]);

            $this->storeTransaction(
                $wallet,
                'lock',
                $amount,
                $before,
                $after,
                'Lock withdrawable balance'
            );

            return $wallet->fresh();

        });

    }

    /*
    |--------------------------------------------------------------------------
    | Unlock
    |--------------------------------------------------------------------------
    */

    public function unlock(
        User $user,
        string $amount
    ): Wallet {

        return DB::transaction(function () use ($user, $amount) {

            $wallet = $this->wallet($user);

            if (
                bccomp(
                    $wallet->locked_balance,
                    $amount,
                    8
                ) < 0
            ) {
                throw new RuntimeException(
                    'Insufficient locked balance.'
                );
            }

            $before = $wallet->locked_balance;

            $after = bcsub(
                $wallet->locked_balance,
                $amount,
                8
            );

            $wallet->update([

                'locked_balance' => $after,

                'withdrawable_balance' => bcadd(
                    $wallet->withdrawable_balance,
                    $amount,
                    8
                ),

            ]);

            $this->storeTransaction(
                $wallet,
                'unlock',
                $amount,
                $before,
                $after,
                'Unlock withdrawable balance'
            );

            return $wallet->fresh();

        });

    }

    /*
    |--------------------------------------------------------------------------
    | Withdraw
    |--------------------------------------------------------------------------
    */

    public function withdraw(
        User $user,
        string $amount,
        string $description,
        ?string $referenceType = null,
        ?int $referenceId = null,
    ): Wallet {

        return DB::transaction(function () use (
            $user,
            $amount,
            $description,
            $referenceType,
            $referenceId
        ) {

            $wallet = $this->wallet($user);

            if (
                bccomp(
                    $wallet->locked_balance,
                    $amount,
                    8
                ) < 0
            ) {
                throw new RuntimeException(
                    'Insufficient locked balance.'
                );
            }

            $before = $wallet->locked_balance;

            $after = bcsub(
                $before,
                $amount,
                8
            );

            $wallet->update([

                'locked_balance' => $after,

                'total_withdrawn' => bcadd(
                    $wallet->total_withdrawn,
                    $amount,
                    8
                ),

            ]);

            $this->storeTransaction(
                $wallet,
                'withdraw',
                $amount,
                $before,
                $after,
                $description,
                $referenceType,
                $referenceId,
            );

            return $wallet->fresh();

        });

    }
    /*
|--------------------------------------------------------------------------
| Finalize Withdrawal
|--------------------------------------------------------------------------
*/

    public function finalizeWithdrawal(
        User $user,
        string $amount,
        string $description,
        ?string $referenceType = null,
        ?int $referenceId = null,
    ): Wallet {

        return DB::transaction(function () use (
            $user,
            $amount,
            $description,
            $referenceType,
            $referenceId
        ) {

            $wallet = $this->wallet($user);

            if (
                bccomp(
                    $wallet->locked_balance,
                    $amount,
                    8
                ) < 0
            ) {
                throw new RuntimeException(
                    'Insufficient locked balance.'
                );
            }

            $before = $wallet->locked_balance;

            $after = bcsub(
                $before,
                $amount,
                8
            );

            $wallet->update([

                'locked_balance' => $after,

                'total_withdrawn' => bcadd(
                    $wallet->total_withdrawn,
                    $amount,
                    8
                ),

            ]);

            $this->storeTransaction(
                $wallet,
                'withdraw',
                $amount,
                $before,
                $after,
                $description,
                $referenceType,
                $referenceId,
            );

            return $wallet->fresh();

        });

    }

    /*
    |--------------------------------------------------------------------------
    | Store Transaction
    |--------------------------------------------------------------------------
    */

    protected function storeTransaction(
        Wallet $wallet,
        string $type,
        string $amount,
        string $before,
        string $after,
        string $description,
        ?string $referenceType = null,
        ?int $referenceId = null,
    ): void {

        WalletTransaction::create([

            'wallet_id'       => $wallet->id,

            'type'            => $type,

            'amount'          => $amount,

            'balance_before'  => $before,

            'balance_after'   => $after,

            'reference_type'  => $referenceType,

            'reference_id'    => $referenceId,

            'description'     => $description,

            'status'          => 'completed',

        ]);

    }
}
