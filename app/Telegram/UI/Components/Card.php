<?php

namespace App\Telegram\UI\Components;

class Card
{
    public static function make(
        string $title,
        string $value,
        string $icon = ''
    ): string {

        return <<<TEXT
━━━━━━━━━━━━━━━━━━

{$icon} <b>{$title}</b>

{$value}

TEXT;

    }
}
