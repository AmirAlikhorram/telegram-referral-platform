<?php

namespace App\Telegram\UI;

class Keyboards
{
    public static function welcome(string $channel): array
    {
        return [
            'inline_keyboard' => [

                [
                    [
                        'text' => Buttons::JOIN_CHANNEL,
                        'url' => $channel,
                    ],
                ],

                [
                    [
                        'text' => Buttons::VERIFY_MEMBERSHIP,
                        'callback_data' => 'check_membership',
                    ],
                ],

            ],
        ];
    }
}
