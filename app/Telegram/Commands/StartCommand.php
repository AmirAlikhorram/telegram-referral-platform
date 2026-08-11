<?php

namespace App\Telegram\Commands;

use App\Services\Referral\ReferralService;
use App\Services\Setting\SettingService;
use App\Services\Telegram\MessageLifecycleService;
use App\Services\Telegram\TelegramService;
use App\Services\Telegram\TelegramUserService;
use App\Telegram\DTO\TelegramUpdate;
use App\Telegram\UI\Keyboards;
use App\Telegram\UI\Messages;

class StartCommand implements CommandInterface
{
    public function __construct(
        private TelegramService $telegramService,
        private TelegramUserService $telegramUserService,
        private ReferralService $referralService,
        private SettingService $settingService,
        private MessageLifecycleService $messageLifecycleService,
    ) {
    }

    public function handle(TelegramUpdate $update): void
    {
        $telegramMessage = $update->message();

        if (! $telegramMessage) {
            return;
        }

        $text = trim($update->text() ?? '');

        $parts = explode(' ', $text);

        $referralCode = $parts[1] ?? null;


        /*
        |--------------------------------------------------------------------------
        | Create / Update User
        |--------------------------------------------------------------------------
        */

        $user = $this->telegramUserService->createOrUpdate(
            $telegramMessage['from'],
            $referralCode
        );


        /*
        |--------------------------------------------------------------------------
        | Register Referral
        |--------------------------------------------------------------------------
        */

        if ($referralCode) {

            $referrer = $this->referralService->findReferrer(
                $referralCode
            );


            if (
                $referrer &&
                $referrer->id !== $user->id &&
                ! $user->referred_by_user_id
            ) {


                /*
                 * ذخیره والد مستقیم در User
                 */
                $user->update([

                    'referred_by_user_id' => $referrer->id,

                ]);


                /*
                 * ساخت رکورد Referral
                 */
                $this->referralService->register(

                    $referrer,

                    $user

                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Replace Bot Message
        |--------------------------------------------------------------------------
        */

        $this->messageLifecycleService->deleteLast(
            $user
        );


        $this->messageLifecycleService->replace(

            $user,

            Messages::welcome($user),

            Keyboards::welcome()

        );
    }
}
