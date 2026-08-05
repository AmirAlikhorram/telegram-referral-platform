<?php

namespace App\Services\Referral;

use App\Models\User;
use App\Models\ReferralUnlockRule;
use App\Services\Wallet\WalletService;
use Illuminate\Support\Facades\DB;

class ReferralUnlockService
{
    public function __construct(
        private WalletService $walletService,
    ) {
    }


    public function process(
        User $user
    ): void {

        DB::transaction(function () use ($user) {


            $wallet = $this->walletService->wallet(
                $user
            );


            $rewardBalance = $wallet->reward_balance;


            if (
                bccomp(
                    $rewardBalance,
                    '0',
                    8
                ) <= 0
            ) {
                return;
            }



            $rule = ReferralUnlockRule::query()

                ->where(
                    'level_id',
                    $user->level_id
                )

                ->where(
                    'is_active',
                    true
                )

                ->first();



            if (! $rule) {

                return;

            }



            if (
                ! $rule->canUnlock(
                    $rewardBalance
                )
            ) {

                return;

            }



            $unlockAmount = $rule->unlockAmount(
                $rewardBalance
            );



            if (
                bccomp(
                    $unlockAmount,
                    '0',
                    8
                ) <= 0
            ) {

                return;

            }



            $this->walletService->unlockReferralReward(

                $user,

                $unlockAmount

            );

        });

    }
}
