<?php

namespace App\Services\Telegram;

use App\Models\TelegramState;
use App\Models\User;

class TelegramStateService
{
    public function set(User $user, string $state, array $data = []): TelegramState
    {
        return TelegramState::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'state' => $state,
                'data' => $data,
            ]
        );
    }

    public function get(User $user): ?TelegramState
    {
        return TelegramState::where(
            'user_id',
            $user->id
        )->first();
    }

    public function clear(User $user): void
    {
        TelegramState::where(
            'user_id',
            $user->id
        )->delete();
    }
}
