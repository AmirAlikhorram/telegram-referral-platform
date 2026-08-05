<?php

namespace App\Services\Level;

use App\Models\Level;
use App\Models\User;
use App\Services\Telegram\NotificationService;
use App\Telegram\UI\Notifications\NotificationMessages;
class LevelService
{

    public function __construct(
        private NotificationService $notificationService,
    ) {}
    /**
     * ارتقاء کاربر به یک Level
     */
    public function upgrade(
        User $user,
        string $levelSlug
    ): User {

        $level = Level::where(
            'slug',
            $levelSlug
        )->firstOrFail();

        $user->update([
            'level_id' => $level->id,
        ]);
        $this->notificationService->send(
            $user,
            NotificationMessages::levelUp($level->name)
        );

        return $user->fresh();
    }

    /**
     * آیا کاربر در این Level قرار دارد؟
     */
    public function isLevel(
        User $user,
        string $slug
    ): bool {

        return optional(
                $user->level
            )->slug === $slug;

    }
}
