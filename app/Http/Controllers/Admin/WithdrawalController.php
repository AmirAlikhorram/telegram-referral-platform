<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use App\Services\Withdrawal\WithdrawalService;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function __construct(
        private WithdrawalService $approvalService
    ) {
    }

    public function index(Request $request)
    {
        $query = WithdrawalRequest::with('user');

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('user', function ($q) use ($search) {

                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('telegram_username', 'like', "%{$search}%")
                    ->orWhere('telegram_id', 'like', "%{$search}%");

            });

        }

        $withdrawals = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.withdrawals.index',
            compact('withdrawals')
        );
    }

    public function approve(WithdrawalRequest $withdrawal)
    {
        $this->approvalService->approve($withdrawal);

        return back()->with(
            'success',
            'درخواست تایید شد.'
        );
    }

    public function paid(WithdrawalRequest $withdrawal)
    {
        $this->approvalService->markAsPaid($withdrawal);

        return back()->with(
            'success',
            'برداشت پرداخت شد.'
        );
    }

    public function reject(WithdrawalRequest $withdrawal)
    {
        $this->approvalService->reject($withdrawal);

        return back()->with(
            'success',
            'برداشت رد شد.'
        );
    }
}
