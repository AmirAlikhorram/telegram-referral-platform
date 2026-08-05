<?php

namespace App\Telegram\UI\Components;

class Error
{
    public static function make(string $message): string
    {
        return <<<TEXT
❌ {$message}

TEXT;
    }
}
