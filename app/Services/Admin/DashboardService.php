<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\Referral;
use App\Models\WithdrawalRequest;
use App\Models\WalletTransaction;

class DashboardService
{
    public function stats(): array
    {
        return [

            'users' => User::count(),

            'active_users' => User::where('status', 'active')->count(),

            'referrals' => Referral::count(),

            'completed_referrals' => Referral::where(
                'status',
                'rewarded'
            )->count(),

            'pending_withdrawals' => WithdrawalRequest::where(
                'status',
                'pending'
            )->count(),

            'paid_withdrawals' => WithdrawalRequest::where(
                'status',
                'paid'
            )->count(),

            'wallet_transactions' => WalletTransaction::count(),

            'wallet_balance' => User::sum('wallet_balance'),

        ];
    }
}
