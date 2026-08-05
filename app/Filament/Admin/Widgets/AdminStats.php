<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Deposit;
use App\Models\WithdrawalRequest;
use App\Models\Wallet;


class AdminStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make(
                'Users',
                User::count()
            )
                ->description('Total users')
                ->color('primary'),

            Stat::make(
                'Active Users',
                User::where('status','active')->count()
            )
                ->color('success'),

            Stat::make(
                'Pending Deposits',
                Deposit::where('status','pending')->count()
            )
                ->color('warning'),

            Stat::make(
                'Pending Withdrawals',
                WithdrawalRequest::where('status','pending')->count()
            )
                ->color('danger'),

            Stat::make(
                'Wallet Balance',
                Wallet::sum('withdrawable_balance')
            )
                ->description('USDT')
                ->color('info'),

            Stat::make(
                'Approved Deposits',
                Deposit::where('status','approved')->sum('amount')
            )
                ->description('USDT')
                ->color('success'),

        ];
    }
}
