<?php

namespace App\Telegram\Commands;

use App\Services\Referral\ReferralService;
use App\Services\Telegram\TelegramService;
use App\Services\Telegram\TelegramUserService;
use App\Telegram\DTO\TelegramUpdate;
use App\Services\Setting\SettingService;

class StartCommand implements CommandInterface
{
    public function __construct(
        private TelegramService $telegramService,
        private TelegramUserService $telegramUserService,
        private ReferralService $referralService,
        private SettingService $settingService,
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

        $user = $this->telegramUserService->createOrUpdate(
            $telegramMessage['from'],
            $referralCode
        );

        if ($referralCode) {

            $referrer = $this->referralService->findReferrer($referralCode);

            if ($referrer) {

                $this->referralService->register(
                    $referrer,
                    $user
                );

            }
        }

        $botUsername = $this->settingService->get(
            'telegram_bot_username',
            config('telegram.bot_username')
        );

        $inviteLink = "https://t.me/{$botUsername}?start={$user->referral_code}";

        $message = "سلام {$user->first_name} 👋

حساب شما با موفقیت ثبت شد.

🔗 لینک دعوت شما:

{$inviteLink}

کد دعوت شما:

{$user->referral_code}

📢 برای فعال شدن سیستم دعوت، ابتدا عضو کانال شوید و سپس روی دکمه «✅ عضو شدم» کلیک کنید.";

        $this->telegramService->sendMessage(
            $update->chatId(),
            $message,
            [
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            [
                                'text' => '📢 عضویت در کانال',
                                'url' => $this->settingService->get(
                                    'telegram_channel_url',
                                    config('telegram.channel_url')
                                )
                            ],
                        ],
                        [
                            [
                                'text' => '✅ عضو شدم',
                                'callback_data' => 'check_membership',
                            ],
                        ],
                    ],
                ]),
            ]
        );
    }
}
