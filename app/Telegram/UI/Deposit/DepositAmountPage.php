<?php

namespace App\Telegram\UI\Deposit;

use App\Telegram\UI\Pages\Page;

class DepositAmountPage extends Page
{
    public static function render(): string
    {
        return <<<HTML
━━━━━━━━━━━━━━━━━━

💳 <b>DEPOSIT</b>

Step 1 of 2

━━━━━━━━━━━━━━━━━━

Enter the amount you transferred.

━━━━━━━━━━━━━━━━━━
HTML;
    }
}
