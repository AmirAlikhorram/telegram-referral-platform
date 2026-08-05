<?php
namespace App\Telegram\UI\Withdraw;

use App\Telegram\UI\Components\Header;
use App\Telegram\UI\Pages\Page;

class WithdrawalNetworkPage extends Page
{
    public static function render(...$args): string
    {
        return

            Header::make(
                'WITHDRAW',
                '💸'
            )

            .

            "Choose withdrawal network.";
    }

    public static function keyboard(): array
    {
        return [

            'inline_keyboard'=>[

                [
                    [
                        'text'=>'🟢 TRC20',
                        'callback_data'=>'withdraw:TRC20',
                    ]
                ],

                [
                    [
                        'text'=>'🔵 ERC20',
                        'callback_data'=>'withdraw:ERC20',
                    ]
                ],

                [
                    [
                        'text'=>'⬅️ Back',
                        'callback_data'=>'dashboard:home',
                    ]
                ]

            ]

        ];
    }
}
