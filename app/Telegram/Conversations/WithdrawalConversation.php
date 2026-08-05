<?php

namespace App\Telegram\Conversations;

use App\Models\User;
use App\Models\TelegramState;
use App\Services\Telegram\MessageLifecycleService;
use App\Services\Telegram\TelegramStateService;
use App\Services\Withdrawal\WithdrawalService;
use App\Telegram\DTO\TelegramUpdate;
use App\Telegram\UI\Components\Alert;
use App\Telegram\UI\Withdraw\WithdrawalWalletPage;
use App\Telegram\UI\Withdraw\WithdrawalConfirmPage;


class WithdrawalConversation
{
    public function __construct(

        private WithdrawalService $withdrawalService,

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

            'withdraw_amount'
            => $this->amount($update, $user),


            'withdraw_wallet'
            => $this->wallet(
                $update,
                $user,
                $state
            ),


            default => false,

        };
    }



    /**
     * Step 1
     * Amount
     */
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
                    'Please enter a valid amount.'
                )
            );

            return true;
        }



        $state = $this->stateService->get($user);


        if (! $state) {

            return true;
        }



        $data = $state->data;


        $data['amount'] = $amount;



        $this->stateService->set(
            $user,
            'withdraw_wallet',
            $data
        );



        $this->messageLifecycleService->replace(
            $user,
            WithdrawalWalletPage::render()
        );


        return true;
    }




    /**
     * Step 2
     * Wallet
     */
    private function wallet(
        TelegramUpdate $update,
        User $user,
        TelegramState $state,
    ): bool {


        $wallet = trim($update->text());



        if (strlen($wallet) < 20) {


            $this->messageLifecycleService->replace(

                $user,

                Alert::error(
                    'Invalid Wallet',
                    'Please enter a valid wallet address.'
                )

            );


            return true;
        }




        $data = $state->data;


        $data['wallet'] = $wallet;



        $this->stateService->set(

            $user,

            'withdraw_confirm',

            $data

        );



        $this->messageLifecycleService->replace(

            $user,

            WithdrawalConfirmPage::render(

                $data['amount'],

                $data['network'],

                $data['wallet']

            ),

            WithdrawalConfirmPage::keyboard()

        );



        return true;

    }






    /**
     * Final Submit
     */
    public function confirm(

        User $user,

        TelegramState $state,

    ): void {


        $data = $state->data;


        $this->messageLifecycleService->replace(

            $user,

            Alert::loading(

                'Submitting Withdrawal',

                'Please wait...'

            )

        );


        try {


            $withdrawal = $this->withdrawalService->create(

                $user,

                $data['amount'],

                $data['network'],

                $data['wallet']

            );


            $this->stateService->clear($user);



            $this->messageLifecycleService->replace(

                $user,

                <<<HTML
━━━━━━━━━━━━━━━━━━

✅ <b>Withdrawal Submitted</b>

━━━━━━━━━━━━━━━━━━

💰 Amount

{$withdrawal->amount} USDT


🌐 Network

{$withdrawal->network}


━━━━━━━━━━━━━━━━━━

Your request has been sent to admin.

━━━━━━━━━━━━━━━━━━
HTML

            );


        } catch (\RuntimeException $e) {


            $this->messageLifecycleService->replace(

                $user,

                Alert::error(

                    'Withdrawal Failed',

                    $e->getMessage()

                )

            );


            return;

        }

    }

}
