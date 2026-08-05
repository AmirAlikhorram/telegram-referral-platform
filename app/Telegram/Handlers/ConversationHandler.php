<?php

namespace App\Telegram\Handlers;

use App\Models\User;
use App\Services\Telegram\MessageLifecycleService;
use App\Services\Telegram\TelegramService;
use App\Services\Telegram\TelegramStateService;
use App\Telegram\Conversations\DepositConversation;
use App\Telegram\Conversations\WithdrawalConversation;
use App\Telegram\DTO\TelegramUpdate;

class ConversationHandler
{
    public function __construct(
        private WithdrawalConversation $withdrawalConversation,
        private DepositConversation $depositConversation,
        private TelegramService $telegramService,
        private TelegramStateService $stateService,
        private MessageLifecycleService $messageLifecycleService,
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

        return match (true) {

            str_starts_with($state->state, 'withdraw')
            => $this->withdrawalConversation->handle($update, $user, $state),

            str_starts_with($state->state, 'deposit')
            => $this->depositConversation->handle($update, $user, $state),

            default => false,
        };

        return false;
    }
}
