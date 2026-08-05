<?php

namespace App\Telegram\UI\Notifications;

use App\Models\Deposit;
use App\Models\WithdrawalRequest;

class NotificationMessages
{
    public static function depositApproved(Deposit $deposit): string
    {
        return <<<HTML
🎉 <b>Deposit Approved</b>

━━━━━━━━━━━━━━━━━━

💰 Amount

{$deposit->amount} USDT

✅ Status

Completed

Your wallet balance has been updated successfully.

━━━━━━━━━━━━━━━━━━
HTML;
    }


    public static function depositRejected(
        Deposit $deposit,
        ?string $reason = null,
    ): string {

        $reasonText = $reason ?? 'Not specified';

        return <<<HTML
❌ <b>Deposit Rejected</b>

━━━━━━━━━━━━━━━━━━

💰 Amount

{$deposit->amount} USDT

Reason

{$reasonText}

━━━━━━━━━━━━━━━━━━
HTML;
    }


    public static function withdrawApproved(
        WithdrawalRequest $withdrawal,
    ): string {

        return <<<HTML
✅ <b>Withdrawal Approved</b>

━━━━━━━━━━━━━━━━━━

💰 Amount

{$withdrawal->amount} USDT

Your withdrawal request has been approved.

It will be processed shortly.

━━━━━━━━━━━━━━━━━━
HTML;
    }


    public static function withdrawRejected(
        WithdrawalRequest $withdrawal,
        ?string $reason = null,
    ): string {

        $reasonText = $reason ?? 'Not specified';

        return <<<HTML
❌ <b>Withdrawal Rejected</b>

━━━━━━━━━━━━━━━━━━

💰 Amount

{$withdrawal->amount} USDT

Reason

{$reasonText}

━━━━━━━━━━━━━━━━━━
HTML;
    }


    public static function withdrawPaid(
        WithdrawalRequest $withdrawal,
    ): string {

        return <<<HTML
🎉 <b>Withdrawal Paid</b>

━━━━━━━━━━━━━━━━━━

💰 Amount

{$withdrawal->amount} USDT

Your withdrawal has been completed successfully.

━━━━━━━━━━━━━━━━━━
HTML;
    }


    public static function referralReward(
        float $amount,
    ): string {

        return <<<HTML
🎉 <b>Referral Reward</b>

━━━━━━━━━━━━━━━━━━

A new referral has been verified.

Reward

{$amount} USDT

has been credited to your wallet.

━━━━━━━━━━━━━━━━━━
HTML;
    }


    public static function levelUp(
        string $level,
    ): string {

        return <<<HTML
🏆 <b>Level Up</b>

━━━━━━━━━━━━━━━━━━

Congratulations!

Your account has been upgraded to

<b>{$level}</b>

━━━━━━━━━━━━━━━━━━
HTML;
    }
}
