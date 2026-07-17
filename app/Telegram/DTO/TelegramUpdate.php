<?php

namespace App\Telegram\DTO;

class TelegramUpdate
{
    public function __construct(
        public readonly array $update,
    ) {
    }

    public function message(): ?array
    {
        return $this->update['message'] ?? null;
    }

    public function from(): ?array
    {
        return $this->message()['from'] ?? null;
    }

    public function text(): ?string
    {
        return $this->message()['text'] ?? null;
    }

    public function callbackQuery(): ?array
    {
        return $this->update['callback_query'] ?? null;
    }

    public function callbackData(): ?string
    {
        return $this->callbackQuery()['data'] ?? null;
    }

    public function callbackMessage(): ?array
    {
        return $this->callbackQuery()['message'] ?? null;
    }

    public function callbackFrom(): ?array
    {
        return $this->callbackQuery()['from'] ?? null;
    }

    public function callbackQueryId(): ?string
    {
        return $this->callbackQuery()['id'] ?? null;
    }

    public function chatId(): ?int
    {
        if ($this->message()) {
            return $this->message()['chat']['id'];
        }

        if ($this->callbackMessage()) {
            return $this->callbackMessage()['chat']['id'];
        }

        return null;
    }
}
