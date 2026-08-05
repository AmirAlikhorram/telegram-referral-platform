<?php

namespace App\Telegram\UI\Deposit;

use App\Telegram\UI\Components\Header;
use App\Telegram\UI\Pages\Page;

class DepositPage extends Page
{
    public static function render(...$args): string
    {
        return

            Header::make('DEPOSIT','💳')

            .

            "Fund your account using USDT.

Press Continue to choose the blockchain network.";
    }

    public static function keyboard(): array
    {
        return [

            'inline_keyboard' => [

                [
                    [
                        'text' => '➡️ Continue',
                        'callback_data' => 'deposit:network',
                    ],
                ],

                [
                    [
                        'text' => '⬅️ Back',
                        'callback_data' => 'dashboard:home',
                    ],
                ],

            ],

        ];
    }
}
