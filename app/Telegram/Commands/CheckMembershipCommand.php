<?php

namespace App\Telegram\Commands;

use App\Models\Referral;
use App\Models\User;
use App\Services\Referral\ReferralVerificationService;
use App\Services\Setting\SettingService;
use App\Services\Telegram\MessageLifecycleService;
use App\Services\Telegram\TelegramService;
use App\Telegram\DTO\TelegramUpdate;
use App\Telegram\UI\Components\Alert;
use App\Telegram\UI\Home\HomePage;

class CheckMembershipCommand
{
    public function __construct(
        private TelegramService $telegramService,
        private ReferralVerificationService $verificationService,
        private SettingService $settingService,
        private MessageLifecycleService $messageLifecycleService,
    ) {
    }

    public function handle(TelegramUpdate $update): void
    {
        if ($update->callbackQueryId()) {
            $this->telegramService->answerCallbackQuery(
                $update->callbackQueryId()
            );
        }

        $from = $update->callbackFrom();

        if (! $from) {
            return;
        }

        $user = User::where(
            'telegram_id',
            $from['id']
        )->first();

        if (! $user) {

            $this->telegramService->sendMessage(
                $update->chatId(),
                Alert::error(
                    'User Not Found',
                    'Please restart the bot using /start.'
                )
            );

            return;
        }

        /**
         * Loading UX
         */
        $this->messageLifecycleService->replace(
            $user,
            Alert::loading(
                'Verifying Membership',
                'Please wait while we verify your Telegram channel membership...'
            )
        );

        $response = $this->telegramService->getChatMember(
            $this->settingService->get(
                'telegram_required_channel',
                config('telegram.required_channel')
            ),
            $user->telegram_id
        );

        \Log::info('CHAT MEMBER RESPONSE', $response);

        if (! isset($response['result']['status'])) {

            $this->messageLifecycleService->replace(
                $user,
                Alert::error(
                    'Verification Failed',
                    'Unable to verify your membership at the moment.'
                )
            );

            return;
        }

        $status = $response['result']['status'];

        if (! in_array($status, [
            'member',
            'administrator',
            'creator',
        ])) {

            $this->messageLifecycleService->replace(
                $user,
                Alert::warning(
                    'Channel Membership Required',
                    "Please join our official Telegram channel first.\n\nAfter joining, press the verification button again."
                )
            );

            return;
        }

        $referral = Referral::where(
            'referred_id',
            $user->id
        )->first();

        if (! $referral) {

//            $this->telegramService->sendMessage(
//                $user->telegram_id,
//                Alert::success(
//                    'Membership Verified',
//                    'Welcome! Your account is now active.'
//                )
//            );

            $this->messageLifecycleService->replace(
                $user,
                HomePage::render($user),

            );

            return;
        }

        if ($referral->isRewarded()) {

//            $this->telegramService->sendMessage(
//                $user->telegram_id,
//                Alert::info(
//                    'Already Verified',
//                    'Your referral reward has already been processed.'
//                )
//            );

            $this->messageLifecycleService->replace(
                $user,
                HomePage::render($user),

            );

            return;
        }

        \Log::info('VERIFY REFERRAL', [
            'user_id' => $user->id,
            'referral' => $referral,
        ]);

        $this->verificationService->verify($referral);

        /**
         * Welcome Notification
         */
//        $this->telegramService->sendMessage(
//            $user->telegram_id,
//            Alert::success(
//                'Welcome!',
//                'Your account has been activated successfully.'
//            )
//        );
//        $this->messageLifecycleService->deleteLast($user);

        /**
         * Dashboard
         */
        $this->messageLifecycleService->replace(
            $user,
            HomePage::render($user),

        );

        /**
         * Notify Referrer
         */
        $this->telegramService->sendMessage(
            $referral->referrer->telegram_id,
            Alert::success(
                'Referral Reward',
                "A new referral has been verified.\n\nYour reward has been credited to your wallet."
            )
        );
    }
}
