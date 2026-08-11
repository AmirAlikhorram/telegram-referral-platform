<?php

namespace App\Telegram\InlineKeyboards;

class BackKeyboard
{
    public static function make(): array
    {
        return [

            'inline_keyboard' => [

                [
                    [
                        'text' => '⬅ BACK',
                        'callback_data' => 'dashboard:home',
                    ],
                ],

            ],

        ];
    }
}
