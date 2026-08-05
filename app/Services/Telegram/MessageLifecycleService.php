<?php

namespace App\Services\Telegram;

use App\Models\User;

class MessageLifecycleService
{
    public function __construct(
        private TelegramService $telegramService,
    ) {
    }

    /**
     * حذف آخرین پیام ربات (در صورت وجود)
     */
    public function deleteLast(User $user): void
    {
        if (! $user->last_bot_message_id) {
            return;
        }

        try {
            $this->telegramService->deleteMessage(
                $user->telegram_id,
                $user->last_bot_message_id
            );
        } catch (\Throwable $e) {
            // اختیاری: Log::warning(...)
        }

        $user->update([
            'last_bot_message_id' => null,
        ]);
    }

    /**
     * ارسال پیام جدید و ذخیره Message ID
     */
    public function send(User $user, string $text, array $options = []): array
    {
        $response = $this->telegramService->sendMessage(
            $user->telegram_id,
            $text,
            $options
        );

        if (
            isset($response['ok']) &&
            $response['ok'] &&
            isset($response['result']['message_id'])
        ) {
            $user->update([
                'last_bot_message_id' => $response['result']['message_id'],
            ]);
        }

        return $response;
    }

    /**
     * حذف پیام قبلی و ارسال پیام جدید
     */
    public function replace(
        User $user,
        string $text,
        ?array $replyMarkup = null,
    ): array {

        $this->deleteLast($user);

        return $this->send(
            $user,
            $text,
            $replyMarkup
                ? ['reply_markup' => $replyMarkup]
                : []
        );
    }
}
