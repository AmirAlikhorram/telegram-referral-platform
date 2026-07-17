<?php

namespace App\Services\Reward;

use App\Models\Referral;
use App\Services\Wallet\WalletService;
use App\Enums\ReferralStatus;

class RewardService
{
    public function __construct(
        private WalletService $walletService
    ) {
    }

    /**
     * پرداخت پاداش دعوت
     */
    public function reward(Referral $referral): void
    {
        if ($referral->status !== ReferralStatus::Completed->value) {
            return;
        }

        $rewardAmount = config('reward.referral_reward');

        $this->walletService->deposit(
            $referral->referrer,
            $rewardAmount,
            'Referral Reward'
        );

        $referral->update([
            'status' => ReferralStatus::Rewarded->value,
        ]);
    }
}
