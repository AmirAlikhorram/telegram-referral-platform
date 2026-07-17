<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Referral;
use App\Models\WithdrawalRequest;
use App\Models\WalletTransaction;
use App\Services\Admin\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboard
    ) {
    }
//    public function index()
//    {
//        return view('admin.dashboard', [
//
//            'usersCount' => User::count(),
//
//            'referralsCount' => Referral::count(),
//
//            'rewardedReferrals' => Referral::where(
//                'status',
//                'rewarded'
//            )->count(),
//
//            'withdrawPending' => WithdrawalRequest::where(
//                'status',
//                'pending'
//            )->count(),
//
//            'withdrawApproved' => WithdrawalRequest::where(
//                'status',
//                'approved'
//            )->count(),
//
//            'withdrawPaid' => WithdrawalRequest::where(
//                'status',
//                'paid'
//            )->count(),
//
//            'transactionsCount' => WalletTransaction::count(),
//
//        ]);
//    }
    public function index()
    {
        return view(
            'admin.dashboard',
            [
                'stats' => $this->dashboard->stats(),
            ]
        );
    }
}
