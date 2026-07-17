<?php

namespace App\Telegram\Commands;

use App\Models\User;
use App\Services\Telegram\TelegramService;
use App\Telegram\DTO\TelegramUpdate;

class WalletCommand implements CommandInterface
{
    public function __construct(
        private TelegramService $telegramService,
    ) {
    }

    public function handle(TelegramUpdate $update): void
    {
        $telegramId = $update->message()['from']['id'];

        $user = User::where(
            'telegram_id',
            $telegramId
        )->first();

        if (!$user) {

            $this->telegramService->sendMessage(
                $update->chatId(),
                'ابتدا /start را ارسال کنید.'
            );

            return;
        }

        $this->telegramService->sendMessage(
            $update->chatId(),
            "💰 کیف پول شما

موجودی:

{$user->wallet_balance}

کد دعوت:

{$user->referral_code}"
        );
    }
}
