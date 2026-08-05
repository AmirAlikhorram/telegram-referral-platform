<?php

namespace App\Telegram\UI;

use App\Models\User;

class Messages
{
    public static function welcome(User $user): string
    {
        return <<<HTML
━━━━━━━━━━━━━━━━━━

🏦 <b>Telegram Referral</b>

━━━━━━━━━━━━━━━━━━

👋 Welcome, <b>{$user->first_name}</b>!

Thank you for joining Telegram Referral.

With our platform you can:

💰 Earn referral rewards

📈 Upgrade your membership level

💸 Withdraw your earnings securely

🎁 Unlock exclusive benefits

━━━━━━━━━━━━━━━━━━

📢 Before getting started, please join our official Telegram channel.

After joining, tap <b>Verify Membership</b> below.

━━━━━━━━━━━━━━━━━━
HTML;
    }
}
