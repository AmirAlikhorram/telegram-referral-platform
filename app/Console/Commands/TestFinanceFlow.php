<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:test-finance-flow')]
#[Description('Command description')]
class TestFinanceFlow extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
