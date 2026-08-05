<?php

namespace App\Telegram\Handlers;

use App\Telegram\Commands\DepositCommand;
use App\Telegram\Commands\HelpCommand;
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
        private DepositCommand $depositCommand,
        private HelpCommand $helpCommand,
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

        if ($text === '/wallet' || $text === '💰 Wallet') {
            $this->walletCommand->handle($update);
            return;
        }

        if (
            $text === '/invite' ||
            $text === '👥 Invite Friends'
        ) {
            $this->inviteCommand->handle($update);
            return;
        }

        if (
            $text === '/account' ||
            $text === '📊 My Account'
        ) {
            \Log::info('ACCOUNT BUTTON CLICKED', [
                'text' => $text,
            ]);
            $this->myAccountCommand->handle($update);
            return;
        }

        if (
            $text === '/withdraw' ||
            $text === '💸 Withdraw'
        ) {
            $this->withdrawalCommand->handle($update);
            return;
        }

        if (
            $text === '/deposit' ||
            $text === '💳 Deposit'
        ) {
            $this->depositCommand->handle($update);
            return;
        }

        if (
            $text === '/help' ||
            $text === '❓ Help'
        ) {
            $this->helpCommand->handle($update);
            return;
        }
    }
}
