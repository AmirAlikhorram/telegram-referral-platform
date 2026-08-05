<?php

namespace App\Telegram\UI\Withdraw;

use App\Telegram\UI\Components\Header;
use App\Telegram\UI\Pages\Page;

class WithdrawalPage extends Page
{
    public static function render(...$args): string
    {
        return

            Header::make(
                'WITHDRAW',
                '💸'
            )

            .

            "Choose the blockchain network for your withdrawal.

━━━━━━━━━━━━━━━━━━

Available Networks

• TRC20
• ERC20

━━━━━━━━━━━━━━━━━━";
    }

    public static function keyboard(): array
    {
        return [

            'inline_keyboard' => [

                [
                    [
                        'text' => '🟢 TRC20',
                        'callback_data' => 'withdraw:network:TRC20',
                    ],
                ],

                [
                    [
                        'text' => '🔵 ERC20',
                        'callback_data' => 'withdraw:network:ERC20',
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
