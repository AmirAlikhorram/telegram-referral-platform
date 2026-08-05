<?php

namespace App\Telegram\Commands;

use App\Models\Referral;
use App\Models\User;
use App\Services\Telegram\MessageLifecycleService;
use App\Services\Telegram\TelegramService;
use App\Telegram\DTO\TelegramUpdate;
use App\Telegram\UI\Account\AccountPage;

class MyAccountCommand implements CommandInterface
{
    public function __construct(
        private TelegramService $telegramService,
        private MessageLifecycleService $messageLifecycleService,
    ) {
    }

    public function handle(TelegramUpdate $update): void
    {
        $from = null;

        if ($update->callbackQuery()) {

            $from = $update->callbackFrom();

        } elseif ($update->message()) {

            $from = $update->message()['from'] ?? null;

        }


        if (! $from) {
            return;
        }


        $telegramId = $from['id'];


        $user = User::with([
            'wallet',
            'level'
        ])
            ->where(
                'telegram_id',
                $telegramId
            )
            ->first();


        if (! $user) {

            $this->telegramService->sendMessage(
                $update->chatId(),
                'Please restart the bot using /start.'
            );

            return;
        }


        $totalReferrals = Referral::where(
            'referrer_id',
            $user->id
        )->count();


        $rewardedReferrals = Referral::where(
            'referrer_id',
            $user->id
        )
            ->where(
                'status',
                'rewarded'
            )
            ->count();



        $this->messageLifecycleService->replace(
            $user,

            AccountPage::render(
                $user,
                $totalReferrals,
                $rewardedReferrals
            ),

            AccountPage::keyboard()
        );
    }
}
