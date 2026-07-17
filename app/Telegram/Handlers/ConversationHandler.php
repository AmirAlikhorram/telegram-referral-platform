<?php

namespace App\Telegram\Handlers;

use App\Models\User;
use App\Services\Telegram\TelegramService;
use App\Services\Telegram\TelegramStateService;
use App\Telegram\DTO\TelegramUpdate;

class ConversationHandler
{
    public function __construct(
        private TelegramService $telegramService,
        private TelegramStateService $stateService,
    ) {
    }

    public function handle(TelegramUpdate $update): bool
    {
        $message = $update->message();

        if (! $message) {
            return false;
        }

        $telegramId = $message['from']['id'];

        $user = User::where(
            'telegram_id',
            $telegramId
        )->first();

        if (! $user) {
            return false;
        }

        $state = $this->stateService->get($user);

        if (! $state) {
            return false;
        }

        switch ($state->state) {

            case 'withdraw_amount':

                $amount = (float) $update->text();

                if ($amount <= 0) {

                    $this->telegramService->sendMessage(
                        $update->chatId(),
                        'مبلغ نامعتبر است.'
                    );

                    return true;
                }

                $this->stateService->set(
                    $user,
                    'withdraw_wallet',
                    [
                        'amount' => $amount,
                    ]
                );

                $this->telegramService->sendMessage(
                    $update->chatId(),
                    'آدرس کیف پول خود را ارسال کنید.'
                );

                return true;

            case 'withdraw_wallet':

                $walletAddress = trim($update->text());

                if (strlen($walletAddress) < 10) {

                    $this->telegramService->sendMessage(
                        $update->chatId(),
                        'آدرس کیف پول معتبر نیست.'
                    );

                    return true;
                }

                $amount = $state->data['amount'];

                $withdrawalService = app(
                    \App\Services\Withdrawal\WithdrawalService::class
                );

                $withdrawalService->create(
                    $user,
                    $amount,
                    $walletAddress
                );

                $this->stateService->clear($user);

                $this->telegramService->sendMessage(
                    $update->chatId(),
                    "✅ درخواست برداشت شما ثبت شد.

💰 مبلغ: {$amount}

📍 آدرس:

<code>{$walletAddress}</code>

درخواست شما پس از بررسی توسط ادمین انجام خواهد شد."
                );

                return true;
        }

        return false;
    }
}
