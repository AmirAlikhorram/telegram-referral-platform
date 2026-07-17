<?php

namespace App\Services\Telegram;

use App\Models\User;
use Illuminate\Support\Str;


class TelegramUserService
{
    public function createOrUpdate(array $telegramUser): User
    {
        $telegramId = $telegramUser['id'];

        $user = User::where('telegram_id', $telegramId)->first();

        if ($user) {
            $user->update([
                'name' => $telegramUser['first_name'] ?? $user->name,
                'telegram_username' => $telegramUser['username'] ?? null,
                'first_name' => $telegramUser['first_name'] ?? null,
                'last_name' => $telegramUser['last_name'] ?? null,
            ]);

            return $user;
        }

        return User::create([
            'name' => $telegramUser['first_name'] ?? 'Telegram User',
            'telegram_id' => $telegramId,
            'telegram_username' => $telegramUser['username'] ?? null,
            'first_name' => $telegramUser['first_name'] ?? null,
            'last_name' => $telegramUser['last_name'] ?? null,
            'referral_code' => $this->generateReferralCode(),
            'status' => 'active',
            'telegram_joined_at' => now(),
        ]);
    }

    private function generateReferralCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }
}
