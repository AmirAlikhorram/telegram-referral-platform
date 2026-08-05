<?php

namespace App\Services\Referral;

use App\Enums\ReferralStatus;
use App\Models\Deposit;
use App\Models\Referral;
use App\Models\ReferralRewardLevel;
use App\Services\Telegram\NotificationService;
use App\Services\Wallet\WalletService;
use App\Telegram\UI\Notifications\NotificationMessages;
use Illuminate\Support\Facades\DB;
use App\Services\Referral\ReferralUnlockService;

class ReferralRewardEngine
{
    public function __construct(

        private WalletService $walletService,

        private NotificationService $notificationService,

        private ReferralUnlockService $unlockService,

    ) {}

    public function distribute(
        Deposit $deposit,
    ): void {

        DB::transaction(function () use ($deposit) {

            $user = $deposit->user;

            /*
            |--------------------------------------------------------------------------
            | Verify Referral
            |--------------------------------------------------------------------------
            */

            $referral = Referral::where(
                'referred_id',
                $user->id
            )->first();

            if (
                $referral->status === ReferralStatus::Rewarded->value
            ){
                return;
            }

            $referral->update([

                'status' => ReferralStatus::Verified->value,

                'verified_at' => now(),

            ]);


            /*
            |--------------------------------------------------------------------------
            | Reward Uplines
            |--------------------------------------------------------------------------
            */

            $currentReferrer = $user->referrer;

            $depth = 1;

            while (

                $currentReferrer &&

                $depth <= 5

            ) {

                $rewardLevel = ReferralRewardLevel::query()

                    ->where('level', $depth)

                    ->where('is_active', true)

                    ->first();

                if (!$rewardLevel) {

                    $currentReferrer = $currentReferrer->referrer;

                    $depth++;

                    continue;
                }

                $reward = round(

                    ($deposit->amount * $rewardLevel->percent) / 100,

                    8

                );

                if ($reward > 0) {

                    $this->walletService->reward(

                        $currentReferrer,

                        $reward,

                        "Referral Reward Level {$depth}",

                        Deposit::class,

                        $deposit->id

                    );

                    $this->unlockService->process(
                        $currentReferrer
                    );

                    $this->notificationService->send(

                        $currentReferrer,

                        NotificationMessages::referralReward($reward)

                    );
                }

                $currentReferrer = $currentReferrer->referrer;

                $depth++;
            }

            /*
            |--------------------------------------------------------------------------
            | Mark Rewarded
            |--------------------------------------------------------------------------
            */

            $referral->update([

                'status' => ReferralStatus::Rewarded->value,

                'rewarded_at' => now(),

            ]);

        });

    }
}
