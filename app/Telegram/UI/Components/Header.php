<?php

namespace App\Telegram\UI\Components;

class Header
{
    public static function make(
        string $title,
        string $icon = '🚀'
    ): string {

        return <<<TEXT
━━━━━━━━━━━━━━━━━━

{$icon} <b>{$title}</b>

━━━━━━━━━━━━━━━━━━

TEXT;

    }
}
