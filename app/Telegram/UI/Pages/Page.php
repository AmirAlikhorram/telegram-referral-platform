<?php

namespace App\Telegram\UI\Pages;

abstract class Page
{
    abstract public static function render(...$data): string;

    public static function keyboard(): ?array
    {
        return null;
    }
}
