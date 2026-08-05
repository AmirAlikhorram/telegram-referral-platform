<?php

namespace App\Telegram\UI\Components\Buttons;

class BackButton
{
    public static function make(
        string $callback='dashboard:home'
    ): array {

        return [

            'text' => '⬅ Back',

            'callback_data' => $callback,

        ];

    }
}
