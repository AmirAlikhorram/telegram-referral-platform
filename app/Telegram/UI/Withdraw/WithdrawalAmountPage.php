<?php

namespace App\Telegram\UI\Withdraw;

use App\Models\User;
use App\Telegram\UI\Pages\Page;

class WithdrawalAmountPage extends Page
{
    public static function render(...$data): string
    {
        /** @var User $user */
        $user = $data[0];

        $wallet = $user->wallet;

        return <<<HTML
━━━━━━━━━━━━━━━━━━

💸 <b>WITHDRAW</b>

Step 1 of 3

━━━━━━━━━━━━━━━━━━

Enter the amount you want to withdraw.

💰 Available Balance

{$wallet->withdrawable_balance} USDT

━━━━━━━━━━━━━━━━━━
HTML;
    }
}
