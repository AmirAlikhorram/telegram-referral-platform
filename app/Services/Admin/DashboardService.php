<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\Referral;
use App\Models\WithdrawalRequest;
use App\Models\WalletTransaction;
use App\Models\Wallet;

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

            'total_reward_balance' => Wallet::sum('reward_balance'),

            'total_withdrawable_balance' => Wallet::sum('withdrawable_balance'),

            'total_locked_balance' => Wallet::sum('locked_balance'),

        ];
    }
}
