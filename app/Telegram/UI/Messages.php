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

🚀 You can start using the platform now.

Invite friends, earn rewards,
manage your wallet and track your earnings.

━━━━━━━━━━━━━━━━━━


HTML;
    }
}
