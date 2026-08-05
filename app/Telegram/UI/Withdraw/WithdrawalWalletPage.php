<?php

namespace App\Telegram\UI\Withdraw;

use App\Telegram\UI\Pages\Page;

class WithdrawalWalletPage extends Page
{
    public static function render(...$data): string
    {
        return <<<HTML
━━━━━━━━━━━━━━━━━━

💸 <b>WITHDRAW</b>

Step 2 of 3

━━━━━━━━━━━━━━━━━━

Enter your USDT wallet address.

⚠️ Make sure the address belongs to the selected blockchain network.

━━━━━━━━━━━━━━━━━━
HTML;
    }
}
