<?php namespace App\Services\Referral;

use App\Models\Referral;
use App\Enums\ReferralStatus;

class ReferralVerificationService
{
    public function __construct(private ReferralRewardEngine $rewardEngine)
    {
    }

    public function verify(Referral $referral): Referral
    {
        if ($referral->status !== ReferralStatus::Pending->value) {
            return $referral;
        }
        $deposit = $referral->referred->activationDeposit;
        if (!$deposit) {
            return $referral;
        }
        $this->rewardEngine->distribute($deposit);
        return $referral->fresh();
    }
}

