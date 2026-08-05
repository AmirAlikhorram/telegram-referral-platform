<?php

namespace App\Telegram\InlineKeyboards;

use App\Telegram\UI\Components\Buttons\PrimaryButton;

class DashboardKeyboard
{
    public static function make(): array
    {
        return [

            'inline_keyboard' => [

                [
                    PrimaryButton::make(
                        'Wallet',
                        'dashboard:wallet'
                    ),

                    PrimaryButton::make(
                        'Deposit',
                        'dashboard:deposit'
                    ),
                ],

                [
                    PrimaryButton::make(
                        'Withdraw',
                        'dashboard:withdraw'
                    ),

                    PrimaryButton::make(
                        'Invite',
                        'dashboard:invite'
                    ),
                ],

                [
                    PrimaryButton::make(
                        'My Account',
                        'dashboard:account'
                    ),
                ],

                [
                    PrimaryButton::make(
                        'Help',
                        'dashboard:help'
                    ),
                ],

            ],

        ];
    }
}
