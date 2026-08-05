<?php

namespace App\Telegram\UI\Components;

class StatusBadge
{
    public static function pending(): string
    {
        return "🟡 <b>Pending Review</b>";
    }

    public static function approved(): string
    {
        return "🟢 <b>Approved</b>";
    }

    public static function rejected(): string
    {
        return "🔴 <b>Rejected</b>";
    }

    public static function processing(): string
    {
        return "⏳ <b>Processing</b>";
    }

    public static function completed(): string
    {
        return "✅ <b>Completed</b>";
    }
}
