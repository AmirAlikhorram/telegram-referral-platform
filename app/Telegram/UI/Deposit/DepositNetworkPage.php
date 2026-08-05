<?php

namespace App\Telegram\UI\Deposit;

use App\Telegram\UI\Components\Header;
use App\Telegram\UI\Pages\Page;

class DepositNetworkPage extends Page
{
    public static function render(...$args): string
    {
        return

            Header::make('SELECT NETWORK','🌐')

            .

            "Choose the blockchain network you will use.

⚠️ Make sure it matches your exchange.";
    }

    public static function keyboard(): array
    {
        return [

            'inline_keyboard' => [

                [
                    [
                        'text' => '🟢 TRC20',
                        'callback_data' => 'deposit:TRC20',
                    ],
                ],

                [
                    [
                        'text' => '🟡 BEP20',
                        'callback_data' => 'deposit:BEP20',
                    ],
                ],

                [
                    [
                        'text' => '🔵 ERC20',
                        'callback_data' => 'deposit:ERC20',
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
