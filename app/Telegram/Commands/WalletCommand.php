<?php

namespace App\Telegram\Commands;

use App\Models\User;
use App\Services\Telegram\TelegramService;
use App\Telegram\DTO\TelegramUpdate;
use App\Telegram\InlineKeyboards\BackKeyboard;
use App\Telegram\UI\PageRenderer;
use App\Telegram\UI\Wallet\WalletPage;

class WalletCommand implements CommandInterface
{
    public function __construct(
        private TelegramService $telegramService,
        private PageRenderer $pageRenderer,
    ) {
    }

    public function handle(TelegramUpdate $update): void
    {
        // پشتیبانی هم از Callback و هم Message
        if ($update->callbackQuery()) {

            $telegramId = $update->callbackFrom()['id'];

        } else {

            $telegramId = $update->message()['from']['id'];

        }

        $user = User::with('wallet')
            ->where('telegram_id', $telegramId)
            ->first();

        if (! $user) {

            $this->telegramService->sendMessage(
                $update->chatId(),
                'ابتدا /start را ارسال کنید.'
            );

            return;
        }

        $wallet = $user->wallet;

        if (! $wallet) {

            $this->messageLifecycleService->replace(
                $user,
                'کیف پول شما هنوز ایجاد نشده است.',
                BackKeyboard::make(),
            );

            return;
        }

        $this->pageRenderer->render(
            $user,
            WalletPage::class,
            $user,
        );
    }
}
