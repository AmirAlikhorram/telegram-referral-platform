<?php

namespace App\Telegram\UI\Home;

use App\Models\User;
use App\Telegram\UI\Pages\Page;
use App\Telegram\UI\Components\Header;
use App\Telegram\UI\Components\Card;
use App\Telegram\UI\Components\Divider;

class HomePage extends Page
{
    public static function render(...$data): string
    {
        /** @var User $user */
        $user = $data[0];

        $wallet = $user->wallet;

        return
            Header::make('HOME', '🏠')

            .

            "👋 Welcome back,\n\n<b>{$user->first_name}</b>\n\n"

            .

            Divider::make()

            .

            Card::make(
                'CURRENT LEVEL',
                $user->level?->name ?? 'Standard',
                '🏆'
            )

            .

            Divider::make()

            .

            Card::make(
                'AVAILABLE BALANCE',
                number_format($wallet?->withdrawable_balance ?? 0, 2) . ' USDT',
                '💰'
            )

            .

            Divider::make()

            .

            Card::make(
                'REWARD BALANCE',
                number_format($wallet?->reward_balance ?? 0, 2) . ' USDT',
                '🎁'
            )

            .

            Divider::make()

            .

            "\nChoose one of the options below.";
    }

    public static function keyboard(): array
    {
        return \App\Telegram\InlineKeyboards\DashboardKeyboard::make();
    }
}
