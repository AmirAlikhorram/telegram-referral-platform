<?php

namespace App\Services\Referral;

use App\Models\Referral;
use App\Models\User;
use App\Enums\ReferralStatus;

class ReferralService
{
    /**
     * پیدا کردن دعوت‌کننده با کد دعوت
     */
    public function findReferrer(string $referralCode): ?User
    {
        return User::where('referral_code', $referralCode)->first();
    }

    /**
     * ثبت Referral
     */
    public function register(User $referrer, User $referred): Referral
    {
        return Referral::firstOrCreate(
            [
                'referrer_id' => $referrer->id,
                'referred_id' => $referred->id,
            ],
            [
                'status' => ReferralStatus::Pending,
            ]
        );
    }
    /**
     * پیدا کردن Referral یک کاربر
     */
    public function findByReferred(User $user): ?Referral
    {
        return Referral::where(
            'referred_id',
            $user->id
        )->first();
    }
}
