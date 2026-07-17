<?php

namespace App\Services\Withdrawal;

use App\Models\User;
use App\Models\WithdrawalRequest;
use App\Services\Wallet\WalletService;

class WithdrawalService
{
    public function __construct(
        private WalletService $walletService,
        private \App\Services\Telegram\TelegramService $telegramService,
    ) {
    }

    /**
     * ثبت درخواست برداشت
     */
    public function create(
        User $user,
        float $amount,
        string $walletAddress,
    ): WithdrawalRequest {

        if ($user->wallet_balance < $amount) {
            throw new \Exception('Insufficient balance.');
        }

        return WithdrawalRequest::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'wallet_address' => $walletAddress,
            'status' => 'pending',
        ]);
    }

    /**
     * تایید درخواست
     */
    public function approve(
        WithdrawalRequest $withdrawal
    ): WithdrawalRequest {

        if ($withdrawal->status !== 'pending') {
            return $withdrawal;
        }

        $this->walletService->withdraw(
            $withdrawal->user,
            $withdrawal->amount,
            'Withdrawal Request'
        );

        $withdrawal->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        $this->telegramService->sendMessage(
            $withdrawal->user->telegram_id,
            "✅ درخواست برداشت شما تایید شد.

💰 مبلغ: {$withdrawal->amount}

درخواست شما در صف پرداخت قرار گرفت."
        );

        return $withdrawal->fresh();
    }

    /**
     * رد درخواست
     */
    public function reject(
        WithdrawalRequest $withdrawal,
        ?string $note = null,
    ): WithdrawalRequest {

        if ($withdrawal->status !== 'pending') {
            return $withdrawal;
        }

        $withdrawal->update([
            'status' => 'rejected',
            'admin_note' => $note,
        ]);
        $this->telegramService->sendMessage(
            $withdrawal->user->telegram_id,
            "❌ درخواست برداشت شما رد شد.

دلیل:

{$note}"
        );

        return $withdrawal->fresh();
    }

    /**
     * ثبت پرداخت نهایی
     */
    public function markAsPaid(
        WithdrawalRequest $withdrawal
    ): WithdrawalRequest {

        if ($withdrawal->status !== 'approved') {
            return $withdrawal;
        }

        $withdrawal->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $this->telegramService->sendMessage(
            $withdrawal->user->telegram_id,
            "🎉 برداشت شما با موفقیت پرداخت شد.

💰 مبلغ:

{$withdrawal->amount}

از همراهی شما سپاسگزاریم."
        );

        return $withdrawal->fresh();
    }
}
