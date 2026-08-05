<?php

namespace App\Telegram\Commands;

use App\Models\User;
use App\Services\Telegram\MessageLifecycleService;
use App\Services\Telegram\TelegramStateService;
use App\Telegram\DTO\TelegramUpdate;
use App\Telegram\UI\Deposit\DepositPage;
use App\Telegram\UI\PageRenderer;

class DepositCommand implements CommandInterface
{
    public function __construct(
        private TelegramStateService $stateService,
        private PageRenderer $pageRenderer,
        private MessageLifecycleService $messageLifecycleService,
    ) {
    }

    public function handle(TelegramUpdate $update): void
    {
        $telegramId = $update->callbackQuery()
            ? $update->callbackFrom()['id']
            : $update->message()['from']['id'];

        $user = User::where(
            'telegram_id',
            $telegramId
        )->first();

        if (! $user) {
            return;
        }

        $this->stateService->clear($user);

        $this->messageLifecycleService->replace(
            $user,
            DepositPage::render(),
            DepositPage::keyboard(),
        );
    }
}
