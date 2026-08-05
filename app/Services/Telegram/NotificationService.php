<?php

namespace App\Services\Telegram;

use App\Models\User;

class NotificationService
{
    public function __construct(
        private TelegramService $telegram,
    ) {
    }

    public function send(
        User $user,
        string $message,
    ): void {

        $this->telegram->sendMessage(
            $user->telegram_id,
            $message
        );
    }
}
