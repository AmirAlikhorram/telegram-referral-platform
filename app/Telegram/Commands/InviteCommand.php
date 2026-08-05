<?php

namespace App\Telegram\Commands;

use App\Models\User;
use App\Models\Referral;
use App\Services\Telegram\MessageLifecycleService;
use App\Services\Telegram\TelegramService;
use App\Telegram\DTO\TelegramUpdate;
use App\Telegram\UI\Invite\InvitePage;

class InviteCommand implements CommandInterface
{
    public function __construct(

        private TelegramService $telegramService,

        private MessageLifecycleService $messageLifecycleService,

    ) {
    }


    public function handle(TelegramUpdate $update): void
    {

        $telegramId = null;


        /*
        |--------------------------------------------------------------------------
        | Message Button
        |--------------------------------------------------------------------------
        */

        if ($update->message()) {

            $telegramId = $update
                ->message()['from']['id'];

        }


        /*
        |--------------------------------------------------------------------------
        | Inline Button Callback
        |--------------------------------------------------------------------------
        */

        if ($update->callbackFrom()) {

            $telegramId = $update
                ->callbackFrom()['id'];

        }


        if (! $telegramId) {
            return;
        }



        $user = User::where(
            'telegram_id',
            $telegramId
        )->first();



        if (! $user) {

            $this->telegramService->sendMessage(

                $telegramId,

                'Please send /start first.'

            );

            return;
        }



        $botUsername = config(
            'telegram.bot_username'
        );


        $inviteLink =
            "https://t.me/{$botUsername}?start={$user->referral_code}";



        $totalReferrals = Referral::where(
            'referrer_id',
            $user->id
        )->count();



        $completedReferrals = Referral::where(
            'referrer_id',
            $user->id
        )
            ->where(
                'status',
                'completed'
            )
            ->count();



        $rewardBalance =
            $user->wallet?->reward_balance ?? 0;



        $this->messageLifecycleService->replace(

            $user,

            InvitePage::render(

                $inviteLink,

                $user->referral_code,

                $totalReferrals,

                $completedReferrals,

                $rewardBalance,

            ),

            InvitePage::keyboard()

        );

    }
}
