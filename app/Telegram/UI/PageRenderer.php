<?php

namespace App\Telegram\UI;

use App\Models\User;
use App\Services\Telegram\MessageLifecycleService;
use App\Telegram\UI\Pages\Page;

class PageRenderer
{
    public function __construct(
        private MessageLifecycleService $messageLifecycleService,
    ) {
    }

    public function render(
        User $user,
        string $pageClass,
        mixed ...$arguments,
    ): void {

        /** @var Page $pageClass */

        $this->messageLifecycleService->replace(

            $user,

            $pageClass::render(...$arguments),

            $pageClass::keyboard(),

        );
    }
}
