<?php

namespace App\Telegram\UI\Components;

class Success
{
    public static function make(string $message): string
    {
        return <<<TEXT
✅ {$message}

TEXT;
    }
}
