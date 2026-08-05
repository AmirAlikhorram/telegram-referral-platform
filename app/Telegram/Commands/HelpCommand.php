<?php

namespace App\Telegram\Commands;

use App\Models\User;
use App\Services\Telegram\MessageLifecycleService;
use App\Telegram\DTO\TelegramUpdate;
use App\Telegram\InlineKeyboards\HelpKeyboard;
use App\Telegram\UI\Help\HelpPage;

class HelpCommand implements CommandInterface
{
    public function __construct(
        private MessageLifecycleService $messageLifecycleService,
    ) {
    }

    public function handle(
        TelegramUpdate $update,
    ): void {

        if ($update->callbackFrom()) {

            $telegramId = $update->callbackFrom()['id'];

        } else {

            $telegramId = $update->from()['id'];

        }

        $user = User::where(
            'telegram_id',
            $telegramId
        )->first();

        if (! $user) {
            return;
        }

        $this->messageLifecycleService->replace(

            $user,

            HelpPage::render(),

            HelpKeyboard::make(),

        );
    }
}
