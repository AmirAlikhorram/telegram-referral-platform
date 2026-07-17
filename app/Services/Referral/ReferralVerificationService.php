<?php

namespace App\Services\Referral;

use App\Models\Referral;
use App\Enums\ReferralStatus;
use App\Services\Reward\RewardService;

class ReferralVerificationService
{
    public function __construct(
        private RewardService $rewardService,
    ) {
    }

    public function verify(Referral $referral): Referral
    {
        if ($referral->status !== ReferralStatus::Pending->value) {
            return $referral;
        }

        $referral->update([
            'status' => ReferralStatus::Completed->value,
            'completed_at' => now(),
        ]);

        $this->rewardService->reward($referral->fresh());

        return $referral->fresh();
    }
}
