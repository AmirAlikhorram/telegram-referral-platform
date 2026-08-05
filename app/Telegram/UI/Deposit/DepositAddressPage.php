<?php

namespace App\Telegram\UI\Deposit;

use App\Telegram\UI\Components\Card;
use App\Telegram\UI\Components\Divider;
use App\Telegram\UI\Components\Header;
use App\Telegram\UI\Pages\Page;

class DepositAddressPage extends Page
{
    public static function render(...$args): string
    {
        $network = $args[0];
        $address = $args[1];

        return

        Header::make('DEPOSIT ADDRESS','📥')

        .

        Card::make(
            'NETWORK',
            $network,
            '🌐'
        )

        .

        Divider::make()

        .

        Card::make(
            'WALLET ADDRESS',
            "<code>{$address}</code>",
            '📥'
        )

        .

        Divider::make()

        .

        "⚠️ Send only USDT using the selected network.

After sending, press the button below.";
    }

    public static function keyboard(): array
    {
        return [

            'inline_keyboard' => [

                [
                    [
                        'text' => '✅ I Have Sent the Deposit',
                        'callback_data' => 'deposit:done',
                    ],
                ],

                [
                    [
                        'text' => '⬅️ Back',
                        'callback_data' => 'dashboard:deposit',
                    ],
                ],

            ],

        ];
    }
}
