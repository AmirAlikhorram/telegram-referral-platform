<?php

namespace App\Telegram\UI\Help;

use App\Telegram\UI\Pages\Page;

class FaqPage extends Page
{
    public static function render(...$data): string
    {
        return <<<HTML
━━━━━━━━━━━━━━━━━━

📖 <b>Frequently Asked Questions</b>

━━━━━━━━━━━━━━━━━━

<b>1.</b> How long does deposit approval take?

Usually within a few minutes after admin review.

━━━━━━━━━━━━━━━━━━

<b>2.</b> When can I withdraw?

After your first approved deposit.

━━━━━━━━━━━━━━━━━━

<b>3.</b> How does the referral system work?

Invite friends using your referral link.
After they complete their first approved deposit,
you automatically receive the referral reward.

━━━━━━━━━━━━━━━━━━

<b>4.</b> Which networks are supported?

• TRC20
• ERC20

━━━━━━━━━━━━━━━━━━

Need more help?
Contact our support.

━━━━━━━━━━━━━━━━━━
HTML;
    }
}
