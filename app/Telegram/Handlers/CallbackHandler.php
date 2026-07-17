<?php

namespace App\Telegram\Handlers;

use App\Telegram\Commands\CheckMembershipCommand;
use App\Telegram\DTO\TelegramUpdate;

class CallbackHandler
{
    public function __construct(
        private CheckMembershipCommand $checkMembershipCommand,
    ) {
    }

    public function handle(TelegramUpdate $update): void
    {
        $data = $update->callbackData();

        if ($data === 'check_membership') {

            $this->checkMembershipCommand->handle($update);

        }
    }
}
