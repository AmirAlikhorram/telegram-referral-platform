<?php

namespace App\Telegram\UI\Wallet;

use App\Models\User;
use App\Telegram\UI\Components\Card;
use App\Telegram\UI\Components\Divider;
use App\Telegram\UI\Components\Header;
use App\Telegram\UI\Pages\Page;

class WalletPage extends Page
{
    public static function render(...$data): string
    {
        /** @var User $user */
        $user = $data[0];

        $wallet = $user->wallet;

        return

            Header::make('MY WALLET', '👛')

            .

            Card::make(
                'AVAILABLE BALANCE',
                number_format($wallet->withdrawable_balance, 2) . ' USDT',
                '💰'
            )

            .

            Divider::make()

            .

            Card::make(
                'REWARD BALANCE',
                number_format($wallet->reward_balance, 2) . ' USDT',
                '🎁'
            )

            .

            Divider::make()

            .

            Card::make(
                'LOCKED BALANCE',
                number_format($wallet->locked_balance, 2) . ' USDT',
                '🔒'
            )

            .

            Divider::make()

            .

            Card::make(
                'LIFETIME EARNINGS',
                number_format($wallet->total_earned, 2) . ' USDT',
                '📈'
            )

            .

            Divider::make()

            .

            Card::make(
                'TOTAL WITHDRAWN',
                number_format($wallet->total_withdrawn, 2) . ' USDT',
                '💸'
            );
    }

    public static function keyboard(): array
    {
        return \App\Telegram\InlineKeyboards\DashboardKeyboard::make();
    }
}
