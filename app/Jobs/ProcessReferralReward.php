<?php

namespace App\Jobs;

use App\Models\Deposit;
use App\Services\Referral\ReferralRewardEngine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class ProcessReferralReward implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;


    public int $tries = 3;

    public int $timeout = 120;


    public function __construct(
        public Deposit $deposit,
    ) {}


    public function handle(
        ReferralRewardEngine $engine
    ): void {

        $engine->distribute(
            $this->deposit
        );

    }
}
