<?php

namespace App\Telegram\Keyboards;

class MainKeyboard
{
    public static function make(): array
    {
        return [

            'keyboard' => [

                [
                    ['text' => '💳 Deposit'],
                    ['text' => '💰 Wallet'],
                ],

                [
                    ['text' => '👥 Invite Friends'],
                    ['text' => '💸 Withdraw'],
                ],

                [
                    ['text' => '📊 My Account'],
                    ['text' => '❓ Help'],
                ],

            ],

            'resize_keyboard' => true,
            'is_persistent' => true,

        ];
    }
}
