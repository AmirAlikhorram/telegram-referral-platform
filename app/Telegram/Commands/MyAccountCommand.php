<?php

namespace App\Telegram\Commands;

use App\Models\User;
use App\Models\Referral;
use App\Services\Telegram\TelegramService;
use App\Telegram\DTO\TelegramUpdate;

class MyAccountCommand implements CommandInterface
{
    public function __construct(
        private TelegramService $telegramService,
    ) {
    }

    public function handle(TelegramUpdate $update): void
    {
        $telegramId = $update->message()['from']['id'];

        $user = User::where('telegram_id', $telegramId)->first();

        if (! $user) {

            $this->telegramService->sendMessage(
                $update->chatId(),
                'ابتدا /start را ارسال کنید.'
            );

            return;
        }

        $totalReferrals = Referral::where(
            'referrer_id',
            $user->id
        )->count();

        $rewardedReferrals = Referral::where(
            'referrer_id',
            $user->id
        )->where(
            'status',
            'rewarded'
        )->count();

        $message = "📊 حساب کاربری

👤 نام:
{$user->first_name}

💰 موجودی کیف پول:
{$user->wallet_balance}

👥 تعداد دعوت‌ها:
{$totalReferrals}

✅ دعوت‌های موفق:
{$rewardedReferrals}

🎁 کد دعوت:

<code>{$user->referral_code}</code>";

        $this->telegramService->sendMessage(
            $update->chatId(),
            $message
        );
    }
}
