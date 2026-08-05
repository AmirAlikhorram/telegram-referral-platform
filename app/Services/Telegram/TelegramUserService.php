<?php

namespace App\Services\Telegram;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Level;

class TelegramUserService
{
    public function createOrUpdate(array $telegramUser): User
    {
        return DB::transaction(function () use ($telegramUser) {

            $telegramId = $telegramUser['id'];

            $user = User::where(
                'telegram_id',
                $telegramId
            )->first();

            if ($user) {

                $user->update([
                    'name' => $telegramUser['first_name'] ?? $user->name,
                    'telegram_username' => $telegramUser['username'] ?? null,
                    'first_name' => $telegramUser['first_name'] ?? null,
                    'last_name' => $telegramUser['last_name'] ?? null,
                ]);

                // اگر کاربر قدیمی Wallet نداشت
                Wallet::firstOrCreate(
                    [
                        'user_id' => $user->id,
                    ],
                    [
                        'reward_balance' => 0,
                        'withdrawable_balance' => 0,
                        'locked_balance' => 0,
                        'total_earned' => 0,
                        'total_withdrawn' => 0,
                    ]
                );

                return $user;
            }

            $starterLevel = Level::where('slug', 'starter')->first();
            $user = User::create([
                'level_id' => $starterLevel?->id,

                'name' => $telegramUser['first_name'] ?? 'Telegram User',

                'telegram_id' => $telegramId,

                'telegram_username' => $telegramUser['username'] ?? null,

                'first_name' => $telegramUser['first_name'] ?? null,

                'last_name' => $telegramUser['last_name'] ?? null,

                'referral_code' => $this->generateReferralCode(),

                'status' => 'active',

                'telegram_joined_at' => now(),

            ]);

            Wallet::create([
                'user_id' => $user->id,
                'reward_balance' => 0,
                'withdrawable_balance' => 0,
                'locked_balance' => 0,
                'total_earned' => 0,
                'total_withdrawn' => 0,
            ]);

            return $user;
        });
    }

    private function generateReferralCode(): string
    {
        do {

            $code = strtoupper(Str::random(8));

        } while (
            User::where(
                'referral_code',
                $code
            )->exists()
        );

        return $code;
    }
}
