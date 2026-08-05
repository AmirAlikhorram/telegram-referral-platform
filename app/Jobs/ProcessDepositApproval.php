<?php

namespace App\Jobs;

use App\Models\Deposit;
use App\Models\User;
use App\Services\Deposit\DepositService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessDepositApproval implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public int $timeout = 60;

    public function __construct(
        public Deposit $deposit,
        public User $admin,
    ) {}

    public function handle(
        DepositService $depositService,
    ): void {

        $deposit = Deposit::findOrFail(
            $this->deposit->id
        );

        $admin = User::findOrFail(
            $this->admin->id
        );

        $depositService->approve(
            $deposit,
            $admin
        );
    }

}
