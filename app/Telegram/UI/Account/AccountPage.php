<?php

namespace App\Telegram\UI\Account;

use App\Models\User;
use App\Telegram\UI\Components\Card;
use App\Telegram\UI\Components\Divider;
use App\Telegram\UI\Components\Header;
use App\Telegram\UI\Pages\Page;

class AccountPage extends Page
{
    public static function render(...$data): string
    {
        $user = $data[0];
        $totalReferrals = $data[1];
        $rewardedReferrals = $data[2];

        return

            Header::make('MY ACCOUNT', '👤')

            .

            Card::make(
                'FULL NAME',
                $user->first_name,
                '🆔'
            )

            .

            Divider::make()

            .

            Card::make(
                'MEMBERSHIP',
                $user->level?->name ?? 'Standard',
                '🏆'
            )

            .

            Divider::make()

            .

            Card::make(
                'TOTAL REFERRALS',
                (string) $totalReferrals,
                '👥'
            )

            .

            Divider::make()

            .

            Card::make(
                'SUCCESSFUL REFERRALS',
                (string) $rewardedReferrals,
                '✅'
            )

            .

            Divider::make()

            .

            Card::make(
                'REFERRAL CODE',
                "<code>{$user->referral_code}</code>",
                '🎁'
            )
            .

        Divider::make()

        .

        Card::make(
            'BALANCE',
            number_format(
                $user->wallet?->withdrawable_balance ?? 0,
                2
            ) . ' USDT',
            '💰'
        );
    }

    public static function keyboard(): array
    {
        return \App\Telegram\InlineKeyboards\BackKeyboard::make();
    }
}
