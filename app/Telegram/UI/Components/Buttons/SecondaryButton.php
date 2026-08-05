<?php

namespace App\Telegram\UI\Components\Buttons;

class SecondaryButton
{
    public static function make(
        string $text,
        string $callback
    ): array {

        return [

            'text' => $text,

            'callback_data' => $callback,

        ];

    }
}
