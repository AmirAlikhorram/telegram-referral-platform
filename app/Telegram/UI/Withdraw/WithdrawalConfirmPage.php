<?php

namespace App\Telegram\UI\Withdraw;

use App\Telegram\UI\Pages\Page;

class WithdrawalConfirmPage extends Page
{
    public static function render(...$data): string
    {
        $amount = $data[0] ?? 0;

        $network = $data[1] ?? '';

        $wallet = $data[2] ?? '';


        return <<<HTML
━━━━━━━━━━━━━━━━━━

✅ <b>CONFIRM WITHDRAWAL</b>

Step 3 of 3

━━━━━━━━━━━━━━━━━━

💸 Amount

{$amount} USDT

━━━━━━━━━━━━━━━━━━

🌐 Network

{$network}

━━━━━━━━━━━━━━━━━━

🏦 Wallet

<code>{$wallet}</code>

━━━━━━━━━━━━━━━━━━

Press Confirm to submit your withdrawal request.

━━━━━━━━━━━━━━━━━━
HTML;
    }


    public static function keyboard(): array
    {
        return [

            'inline_keyboard' => [

                [
                    [
                        'text' => '✅ Confirm',
                        'callback_data' => 'withdraw:confirm',
                    ],
                ],

                [
                    [
                        'text' => '❌ Cancel',
                        'callback_data' => 'dashboard:home',
                    ],
                ],

            ],

        ];
    }
}
