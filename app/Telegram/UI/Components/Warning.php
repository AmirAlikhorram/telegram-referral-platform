<?php

namespace App\Telegram\UI\Components;

class Warning
{
    public static function make(string $message): string
    {
        return <<<TEXT
⚠️ {$message}

TEXT;
    }
}
