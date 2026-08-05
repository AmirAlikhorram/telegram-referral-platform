<?php

namespace App\Telegram\InlineKeyboards;

use App\Services\Setting\SettingService;

class HelpKeyboard
{
    public static function make(): array
    {
        $settings = app(SettingService::class);

        $keyboard = [];

        $keyboard[] = [[
            'text' => '📖 FAQ',
            'callback_data' => 'help:faq',
        ]];

        $support = $settings->get('telegram_support_url');

        if (!empty($support)) {

            $keyboard[] = [[
                'text' => '💬 Support',
                'url' => $support,
            ]];

        }

        $channel = $settings->get('telegram_channel_url');

        if (!empty($channel)) {

            $keyboard[] = [[
                'text' => '📢 Channel',
                'url' => $channel,
            ]];

        }

        $keyboard[] = [[
            'text' => '⬅️ Back',
            'callback_data' => 'dashboard:home',
        ]];

        return [
            'inline_keyboard' => $keyboard,
        ];
    }
}
