<?php

namespace App\Telegram\UI\Components;

class Alert
{
    public static function success(string $title, ?string $body = null): string
    {
        return self::build('✅', $title, $body);
    }

    public static function error(string $title, ?string $body = null): string
    {
        return self::build('❌', $title, $body);
    }

    public static function warning(string $title, ?string $body = null): string
    {
        return self::build('⚠️', $title, $body);
    }

    public static function info(string $title, ?string $body = null): string
    {
        return self::build('ℹ️', $title, $body);
    }

    public static function loading(string $title = 'Processing...', ?string $body = null): string
    {
        return self::build('⏳', $title, $body);
    }

    protected static function build(
        string $icon,
        string $title,
        ?string $body,
    ): string {

        $message = <<<HTML

━━━━━━━━━━━━━━━━━━

{$icon} <b>{$title}</b>

HTML;

        if ($body) {
            $message .= "\n\n{$body}";
        }

        $message .= "\n\n━━━━━━━━━━━━━━━━━━";

        return $message;
    }
}
