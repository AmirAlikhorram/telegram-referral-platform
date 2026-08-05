<?php

namespace App\Services\Referral;

use App\Enums\ReferralStatus;
use App\Models\Referral;
use App\Models\User;

class ReferralService
{
    /**
     * پیدا کردن دعوت‌کننده با کد دعوت.
     */
    public function findReferrer(string $referralCode): ?User
    {
        return User::query()
            ->where('referral_code', $referralCode)
            ->first();
    }

    /**
     * ثبت رابطه دعوت.
     */
    public function register(
        User $referrer,
        User $referred
    ): Referral {


        if (!$referred->referred_by_user_id) {

            $referred->update([

                'referred_by_user_id' => $referrer->id,

            ]);

        }


        return Referral::firstOrCreate(

            [
                'referrer_id' => $referrer->id,

                'referred_id' => $referred->id,
            ],

            [

                'referral_code' => $referrer->referral_code,

                'status' => ReferralStatus::Pending->value,

            ]

        );

    }

    /**
     * دریافت Referral مربوط به یک کاربر.
     */
    public function findByReferred(User $user): ?Referral
    {
        return Referral::query()
            ->where('referred_id', $user->id)
            ->first();
    }

    /**
     * آیا کاربر توسط شخصی دعوت شده است؟
     */
    public function hasReferrer(User $user): bool
    {
        return Referral::query()
            ->where('referred_id', $user->id)
            ->exists();
    }
}
