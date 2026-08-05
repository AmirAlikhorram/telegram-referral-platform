<?php

namespace App\Telegram\UI\Help;

use App\Telegram\UI\Pages\Page;

class HelpPage extends Page
{
    public static function render(...$data): string
    {
        return <<<HTML
━━━━━━━━━━━━━━━━━━

❓ <b>HELP CENTER</b>

━━━━━━━━━━━━━━━━━━

Need assistance?

Choose one of the options below.

━━━━━━━━━━━━━━━━━━

📌 Frequently Asked Questions

💬 Contact Support

🌐 Official Channel

━━━━━━━━━━━━━━━━━━
HTML;
    }
}
