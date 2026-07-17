<?php

namespace App\Telegram\Commands;

use App\Models\User;
use App\Services\Telegram\TelegramService;
use App\Telegram\DTO\TelegramUpdate;

class InviteCommand implements CommandInterface
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

        $botUsername = config('telegram.bot_username');

        $inviteLink = "https://t.me/{$botUsername}?start={$user->referral_code}";

        $message = "🎉 لینک دعوت اختصاصی شما

🔗 {$inviteLink}

کد دعوت:

<code>{$user->referral_code}</code>

با ارسال این لینک برای دوستان خود، پس از تکمیل شرایط دعوت، پاداش دریافت خواهید کرد.";

        $this->telegramService->sendMessage(
            $update->chatId(),
            $message
        );
    }
}
