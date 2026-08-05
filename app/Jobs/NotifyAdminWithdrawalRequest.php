<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\WithdrawalRequest;
use App\Services\Telegram\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class NotifyAdminWithdrawalRequest implements ShouldQueue
{

    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;



    public function __construct(

        public WithdrawalRequest $withdrawal,

    ) {
    }



    public function handle(

        TelegramService $telegram,

    ): void {



        $admins = User::where(
            'is_admin',
            true
        )
            ->whereNotNull(
                'telegram_id'
            )
            ->get();




        foreach ($admins as $admin) {



            $telegram->sendMessage(

                $admin->telegram_id,


                <<<HTML
💸 <b>New Withdrawal Request</b>

━━━━━━━━━━━━━━━━━━

👤 User

{$this->withdrawal->user->first_name}


🆔 Telegram ID

{$this->withdrawal->user->telegram_id}


━━━━━━━━━━━━━━━━━━


💰 Amount

{$this->withdrawal->amount} USDT


🌐 Network

{$this->withdrawal->network}


━━━━━━━━━━━━━━━━━━


🏦 Wallet

<code>{$this->withdrawal->wallet_address}</code>


━━━━━━━━━━━━━━━━━━


Open Admin Panel to review.

HTML

            );


        }


    }


}
