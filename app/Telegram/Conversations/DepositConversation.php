<?php

namespace App\Telegram\Conversations;

use App\Models\TelegramState;
use App\Models\User;
use App\Services\Deposit\DepositService;
use App\Services\Telegram\MessageLifecycleService;
use App\Services\Telegram\TelegramStateService;
use App\Telegram\DTO\TelegramUpdate;
use App\Telegram\UI\Components\Alert;
use App\Telegram\UI\Deposit\DepositReceiptPage;

class DepositConversation
{
    public function __construct(
        private DepositService $depositService,
        private TelegramStateService $stateService,
        private MessageLifecycleService $messageLifecycleService,
    ) {
    }

    public function handle(
        TelegramUpdate $update,
        User $user,
        TelegramState $state,
    ): bool {

        return match ($state->state) {

            'deposit_amount'
            => $this->amount($update, $user),

            'deposit_txid'
            => $this->txid($update, $user, $state),

            default => false,

        };
    }

    private function amount(
        TelegramUpdate $update,
        User $user,
    ): bool {

        $amount = (float) trim($update->text());

        if ($amount <= 0) {

            $this->messageLifecycleService->replace(
                $user,
                Alert::error(
                    'Invalid Amount',
                    'Please enter an amount greater than zero.'
                )
            );

            return true;
        }

        $state = $this->stateService->get($user);

        if (! $state) {

            $this->messageLifecycleService->replace(
                $user,
                Alert::error(
                    'Session Expired',
                    'Please start the deposit process again.'
                )
            );

            return true;
        }

        $data = $state->data;

        $data['amount'] = $amount;

        $this->stateService->set(
            $user,
            'deposit_txid',
            $data,
        );

        $this->messageLifecycleService->replace(
            $user,
            Alert::info(
                'Transaction Hash Required',
                'Please send the TXID (transaction hash) of your transfer.'
            )
        );

        return true;
    }

    private function txid(
        TelegramUpdate $update,
        User $user,
        TelegramState $state,
    ): bool {

        $txid = trim($update->text());

        if (strlen($txid) < 20) {

            $this->messageLifecycleService->replace(
                $user,
                Alert::error(
                    'Invalid TXID',
                    'The transaction hash appears to be invalid.'
                )
            );

            return true;
        }

        /**
         * Loading
         */
        $this->messageLifecycleService->replace(
            $user,
            Alert::loading(
                'Submitting Deposit',
                'Please wait while your request is being submitted...'
            )
        );

        $data = $state->data;

        if (empty($data['wallet_address'])) {

            $this->messageLifecycleService->replace(
                $user,
                Alert::error(
                    'Wallet Address Missing',
                    'Please restart the deposit process.'
                )
            );

            return true;
        }

        $deposit = $this->depositService->create(

            $user,

            $data['amount'],

            $data['network'],

            $txid,

            $data['wallet_address'],

        );

        $this->stateService->clear($user);

        $this->messageLifecycleService->replace(

            $user,

            DepositReceiptPage::render($deposit)

        );

        return true;
    }
}
