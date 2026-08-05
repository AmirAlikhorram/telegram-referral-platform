<?php

namespace App\Telegram\Commands;

use App\Models\User;
use App\Services\Setting\SettingService;
use App\Services\Telegram\TelegramStateService;
use App\Telegram\DTO\TelegramUpdate;
use App\Telegram\UI\Components\Alert;
use App\Telegram\UI\Deposit\DepositAddressPage;
use App\Telegram\UI\PageRenderer;

class DepositNetworkCommand
{
    public function __construct(
        private SettingService $settingService,
        private TelegramStateService $stateService,
        private PageRenderer $pageRenderer,
    ) {
    }

    public function handle(
        TelegramUpdate $update,
        string $network,
    ): void {

        $telegramId = $update->callbackFrom()['id'];

        $user = User::where(
            'telegram_id',
            $telegramId
        )->first();

        if (!$user) {
            return;
        }

        $address = $this->settingService->get(
            'deposit_' . strtolower($network) . '_address'
        );

        if (! $address) {

            $this->pageRenderer->render(
                $user,
                Alert::error(
                    'Wallet Address Missing',
                    "Deposit wallet address for {$network} is not configured."
                )
            );

            return;
        }


        $this->stateService->set(

            $user,

            'deposit_amount',

            [

                'network' => $network,

                'wallet_address' => $address,

            ]

        );

        $this->pageRenderer->render(

            $user,

            DepositAddressPage::class,

            $network,

            $address

        );
    }
}
