<?php

namespace App\Telegram\Commands;

use App\Models\User;
use App\Services\Telegram\MessageLifecycleService;
use App\Services\Telegram\TelegramService;
use App\Services\Telegram\TelegramStateService;
use App\Telegram\DTO\TelegramUpdate;
use App\Telegram\UI\Withdraw\WithdrawalPage;

class WithdrawalCommand implements CommandInterface
{
    public function __construct(
        private TelegramService $telegramService,
        private TelegramStateService $stateService,
        private MessageLifecycleService $messageLifecycleService,
    ) {
    }

    public function handle(TelegramUpdate $update): void
    {
        $from = $update->callbackFrom()
            ?? ($update->message()['from'] ?? null);

        if (! $from) {
            return;
        }

        $telegramId = $from['id'];

        $user = User::where(
            'telegram_id',
            $telegramId
        )->first();

        if (! $user) {

            $this->telegramService->sendMessage(
                $update->chatId(),
                'Please send /start first.'
            );

            return;
        }

        $this->messageLifecycleService->replace(
            $user,
            WithdrawalPage::render(),
            WithdrawalPage::keyboard(),
        );
    }
}
