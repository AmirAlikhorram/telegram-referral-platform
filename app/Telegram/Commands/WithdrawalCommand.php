<?php

namespace App\Telegram\Commands;

use App\Models\User;
use App\Services\Telegram\TelegramService;
use App\Services\Telegram\TelegramStateService;
use App\Telegram\DTO\TelegramUpdate;

class WithdrawalCommand implements CommandInterface
{
    public function __construct(
        private TelegramService $telegramService,
        private TelegramStateService $stateService,
    ) {
    }

    public function handle(TelegramUpdate $update): void
    {
        $telegramId = $update->message()['from']['id'];

        $user = User::where(
            'telegram_id',
            $telegramId
        )->first();

        if (! $user) {

            $this->telegramService->sendMessage(
                $update->chatId(),
                'ابتدا /start را ارسال کنید.'
            );

            return;
        }

        $this->stateService->set(
            $user,
            'withdraw_amount'
        );

        $this->telegramService->sendMessage(
            $update->chatId(),
            "💸 درخواست برداشت

مبلغ برداشت را وارد کنید."
        );
    }
}
