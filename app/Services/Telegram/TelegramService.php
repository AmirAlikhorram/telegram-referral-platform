<?php

namespace App\Services\Telegram;

use App\Telegram\Keyboards\MainKeyboard;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    public function __construct(
        private readonly HttpFactory $http,
    ) {
    }

    private function apiUrl(): string
    {
        return sprintf(
            '%s/bot%s',
            config('telegram.api_url'),
            config('telegram.bot_token'),
        );
    }

    /**
     * ارسال درخواست به Telegram API
     */
    private function request(
        string $method,
        array $payload = [],
    ): array {

        $response = $this->http
            ->retry(3, 500)
            ->timeout(20)
            ->post(
                "{$this->apiUrl()}/{$method}",
                $payload
            );

        if ($response->failed()) {

            if (

                $method === 'answerCallbackQuery'

                &&

                str_contains(
                    $response->body(),
                    'query is too old'
                )

            ) {

                return [];

            }

            Log::error(

                'Telegram API Error',

                [

                    'method' => $method,

                    'status' => $response->status(),

                    'body' => $response->body(),

                ]

            );

            return [];

        }

        return $response->json();
    }

    /**
     * ارسال پیام
     */
    public function sendMessage(
        int|string $chatId,
        string $text,
        array $options = [],
    ): array {

        return $this->request(
            'sendMessage',
            array_merge([
                'chat_id'      => $chatId,
                'text'         => $text,
                'parse_mode'   => 'HTML',
                'reply_markup' => MainKeyboard::make(),
            ], $options),
        );
    }

    /**
     * حذف پیام
     */
    public function deleteMessage(
        int|string $chatId,
        int $messageId,
    ): array {

        return $this->request('deleteMessage', [
            'chat_id'    => $chatId,
            'message_id' => $messageId,
        ]);
    }

    /**
     * ویرایش پیام
     */
    public function editMessage(
        int|string $chatId,
        int $messageId,
        string $text,
        ?array $replyMarkup = null,
        array $options = [],
    ): array {

        $payload = array_merge([
            'chat_id'    => $chatId,
            'message_id' => $messageId,
            'text'       => $text,
            'parse_mode' => 'HTML',
        ], $options);

        if ($replyMarkup !== null) {
            $payload['reply_markup'] = $replyMarkup;
        }

        return $this->request(
            'editMessageText',
            $payload,
        );
    }

    /**
     * وضعیت عضو کانال
     */
    public function getChatMember(
        string $channel,
        int|string $userId,
    ): array {

        return $this->request('getChatMember', [
            'chat_id' => $channel,
            'user_id' => $userId,
        ]);
    }

    /**
     * ثبت Webhook
     */
    public function setWebhook(
        string $url,
    ): array {

        return $this->request('setWebhook', [
            'url' => $url,
        ]);
    }

    /**
     * پاسخ CallbackQuery
     */
    public function answerCallbackQuery(
        string $callbackQueryId,
        ?string $text = null,
        bool $showAlert = false,
    ): array {

        try {

            return $this->request(

                'answerCallbackQuery',

                [

                    'callback_query_id' => $callbackQueryId,

                    'text' => $text,

                    'show_alert' => $showAlert,

                ]

            );

        } catch (\Throwable $e) {

            if (
                str_contains(
                    $e->getMessage(),
                    'query is too old'
                )
                ||
                str_contains(
                    $e->getMessage(),
                    'query ID is invalid'
                )
            ) {

                // Callback منقضی شده؛ نیازی به توقف برنامه نیست.
                return [];

            }

            throw $e;

        }

    }
    public function editMessageText(
        int|string $chatId,
        int $messageId,
        string $text,
        ?array $replyMarkup = null,
    ): array {

        return $this->editMessage(
            $chatId,
            $messageId,
            $text,
            $replyMarkup
        );
    }
}
