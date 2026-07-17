<?php

namespace App\Telegram\Commands;

use App\Models\Referral;
use App\Models\User;
use App\Services\Referral\ReferralVerificationService;
use App\Services\Telegram\TelegramService;
use App\Telegram\DTO\TelegramUpdate;
use App\Services\Setting\SettingService;

class CheckMembershipCommand
{
    public function __construct(
        private TelegramService $telegramService,
        private ReferralVerificationService $verificationService,
        private SettingService $settingService,
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
                'کاربر یافت نشد.'
            );

            return;
        }

        $response = $this->telegramService->getChatMember(
            $this->settingService->get(
                'telegram_required_channel',
                config('telegram.required_channel')
            ),
            $user->telegram_id
        );
        \Log::info('CHAT MEMBER RESPONSE', $response);

        if (! isset($response['result']['status'])) {

            $this->telegramService->sendMessage(
                $update->chatId(),
                'خطا در بررسی عضویت کانال.'
            );

            return;
        }

        $status = $response['result']['status'];

        if (! in_array($status, [
            'member',
            'administrator',
            'creator',
        ])) {

            $this->telegramService->sendMessage(
                $update->chatId(),
                "❌ ابتدا عضو کانال شوید."
            );

            return;
        }

        $referral = Referral::where(
            'referred_id',
            $user->id
        )->first();

        if (! $referral) {

            $this->telegramService->sendMessage(
                $update->chatId(),
                "✅ عضویت شما تایید شد."
            );

            return;
        }

        if ($referral->isRewarded()) {

            $this->telegramService->sendMessage(
                $update->chatId(),
                "✅ قبلاً پاداش این دعوت ثبت شده است."
            );

            return;
        }
        \Log::info('VERIFY REFERRAL', [
            'user_id' => $user->id,
            'referral' => $referral,
        ]);
        $this->verificationService->verify($referral);

        $this->telegramService->sendMessage(
            $update->chatId(),
            "🎉 عضویت شما تایید شد.

پاداش دعوت با موفقیت ثبت شد."
        );

        $this->telegramService->sendMessage(
            $referral->referrer->telegram_id,
            "🎉 یک دعوت جدید تایید شد.

💰 پاداش به کیف پول شما اضافه شد."
        );
    }
}
