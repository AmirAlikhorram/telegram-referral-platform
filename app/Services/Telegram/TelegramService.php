<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('telegram.api_url')
            . '/bot'
            . config('telegram.bot_token');
    }

    /**
     * ارسال درخواست به Telegram API
     */
    protected function request(string $method, array $data = []): array
    {
        $response = Http::post(
            "{$this->baseUrl}/{$method}",
            $data
        );

        if ($response->failed()) {

            Log::error('Telegram API Error', [

                'method' => $method,

                'status' => $response->status(),

                'body' => $response->body(),

            ]);

            return [];
        }

        return $response->json();
    }

    /**
     * ارسال پیام
     */
//    public function sendMessage(
//        int|string $chatId,
//        string $text,
//        array $options = []
//    ): array {
//
//        return $this->request(
//            'sendMessage',
//            array_merge([
//                'chat_id' => $chatId,
//                'text' => $text,
//                'parse_mode' => 'HTML',
//            ], $options)
//        );
//    }
    public function sendMessage(
        int|string $chatId,
        string $text,
        array $options = []
    ): array {

        return $this->request(
            'sendMessage',
            array_merge([
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML',

                'reply_markup' => [
                    'keyboard' => [
                        [
                            ['text' => '💰 کیف پول'],
                            ['text' => '👥 دعوت دوستان'],
                        ],
                        [
                            ['text' => '💸 برداشت'],
                            ['text' => '📊 حساب من'],
                        ],
                    ],
                    'resize_keyboard' => true,
                    'persistent' => true,
                ],

            ], $options)
        );
    }
    /**
     * بررسی عضویت در کانال
     */
    public function getChatMember(
        string $channel,
        int|string $userId
    ): array {

        return $this->request(
            'getChatMember',
            [
                'chat_id' => $channel,
                'user_id' => $userId,
            ]
        );
    }

    /**
     * ثبت Webhook
     */
    public function setWebhook(string $url): array
    {
        return $this->request(
            'setWebhook',
            [
                'url' => $url,
            ]
        );
    }

    /**
     * پاسخ به Callback Query
     */
    public function answerCallbackQuery(
        string $callbackQueryId,
        ?string $text = null,
        bool $showAlert = false
    ): array {

        return $this->request(
            'answerCallbackQuery',
            [
                'callback_query_id' => $callbackQueryId,
                'text' => $text,
                'show_alert' => $showAlert,
            ]
        );
    }
}
