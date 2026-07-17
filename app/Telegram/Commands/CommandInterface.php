<?php

namespace App\Telegram\Commands;

use App\Telegram\DTO\TelegramUpdate;

interface CommandInterface
{
    public function handle(TelegramUpdate $update): void;
}
