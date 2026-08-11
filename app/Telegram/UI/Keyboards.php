<?php

namespace App\Telegram\UI;

class Keyboards
{
    public static function welcome(): array
    {
        return [
            'inline_keyboard' => [

                [
                    [
                        'text' => Buttons::DASHBOARD,
                        'callback_data' => 'dashboard:home',
                    ],
                ],

            ],
        ];
    }
}
