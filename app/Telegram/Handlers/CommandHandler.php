<?php

namespace App\Telegram\Handlers;

use App\Telegram\Commands\StartCommand;
use App\Telegram\Commands\WalletCommand;
use App\Telegram\DTO\TelegramUpdate;
use App\Telegram\Commands\InviteCommand;
use App\Telegram\Commands\MyAccountCommand;
use App\Telegram\Commands\WithdrawalCommand;

class CommandHandler
{
    public function __construct(
        private ConversationHandler $conversationHandler,
        private StartCommand $startCommand,
        private WalletCommand $walletCommand,
        private InviteCommand $inviteCommand,
        private MyAccountCommand $myAccountCommand,
        private WithdrawalCommand $withdrawalCommand,
    ) {
    }

    public function handle(TelegramUpdate $update): void
    {
        if ($this->conversationHandler->handle($update)) {
            return;
        }
        $text = trim($update->text() ?? '');

        if (str_starts_with($text, '/start')) {
            $this->startCommand->handle($update);
            return;
        }

        if ($text === '/wallet' || $text === '💰 کیف پول') {
            $this->walletCommand->handle($update);
            return;
        }
        if (
            $text === '/invite' ||
            $text === '👥 دعوت دوستان'
        ) {
            $this->inviteCommand->handle($update);
            return;
        }
        if (
            $text === '/account' ||
            $text === '📊 حساب من'
        ) {
            $this->myAccountCommand->handle($update);
            return;
        }
        if (
            $text === '/withdraw' ||
            $text === '💸 برداشت'
        ) {
            $this->withdrawalCommand->handle($update);
            return;
        }
    }
}
