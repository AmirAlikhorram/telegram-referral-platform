<?php

namespace App\Telegram\UI\Deposit;

use App\Models\Deposit;
use App\Telegram\UI\Components\Header;
use App\Telegram\UI\Components\Card;
use App\Telegram\UI\Components\Divider;
use App\Telegram\UI\Pages\Page;

class DepositReceiptPage extends Page
{
    public static function render(...$args): string
    {
        /** @var Deposit $deposit */
        $deposit = $args[0];

        return

            Header::make('DEPOSIT SUBMITTED', '⏳')

            .

            Divider::make()

            .

            Card::make(
                'AMOUNT',
                number_format($deposit->amount, 2) . ' USDT',
                '💰'
            )

            .

            Divider::make()

            .

            Card::make(
                'NETWORK',
                $deposit->network,
                '🌐'
            )

            .

            Divider::make()

            .

            Card::make(
                'STATUS',
                ucfirst($deposit->status),
                '📌'
            )

            .

            Divider::make()

            .

            "Your deposit request has been submitted.\n\n"
            .
            "Please wait for admin confirmation.";
    }


    public static function keyboard(): array
    {
        return [
            'inline_keyboard' => [
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
