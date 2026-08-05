<?php

namespace App\Telegram\UI\Invite;

use App\Telegram\UI\Pages\Page;

class InvitePage extends Page
{
    public static function render(...$data): string
    {
        [
            $inviteLink,
            $referralCode,
            $totalReferrals,
            $completedReferrals,
            $rewardBalance,
        ] = $data;


        return <<<HTML
━━━━━━━━━━━━━━━━━━

🎉 <b>INVITE FRIENDS</b>

━━━━━━━━━━━━━━━━━━

Invite your friends and earn rewards.

🔗 <b>Your Invite Link</b>

<code>{$inviteLink}</code>

━━━━━━━━━━━━━━━━━━

🎟 <b>Referral Code</b>

<code>{$referralCode}</code>

━━━━━━━━━━━━━━━━━━

👥 <b>Statistics</b>

Total Invites:
{$totalReferrals}

Completed Invites:
{$completedReferrals}

💰 Referral Rewards:
{$rewardBalance} USDT

━━━━━━━━━━━━━━━━━━

Share your link with friends.

Rewards will be credited after they complete the requirements.

━━━━━━━━━━━━━━━━━━
HTML;
    }


    public static function keyboard(): array
    {
        return [

            'inline_keyboard' => [

                [
                    [
                        'text' => '⬅️ Back',
                        'callback_data' => 'dashboard:home',
                    ],
                ],

            ],

        ];
    }
}
