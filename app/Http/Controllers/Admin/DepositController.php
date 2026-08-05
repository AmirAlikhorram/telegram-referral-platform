<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApproveDepositRequest;
use App\Http\Requests\Admin\RejectDepositRequest;
use App\Jobs\ProcessDepositApproval;
use App\Models\Deposit;
use App\Services\Deposit\DepositService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DepositController extends Controller
{
    public function __construct(
        private DepositService $depositService,
    ) {
    }

    public function index(): View
    {
        $deposits = Deposit::with('user')
            ->latest()
            ->paginate(20);

        return view(
            'admin.deposits.index',
            compact('deposits')
        );
    }

    public function show(
        Deposit $deposit
    ): View {

        $deposit->load('user');

        return view(
            'admin.deposits.show',
            compact('deposit')
        );
    }

    public function approve(
        ApproveDepositRequest $request,
        Deposit $deposit
    ): RedirectResponse {

        ProcessDepositApproval::dispatch(
            $deposit,
            auth()->user()
        );

        return redirect()
            ->route('admin.deposits.show', $deposit)
            ->with(
                'success',
                'Deposit approved successfully.'
            );
    }

    public function reject(
        RejectDepositRequest $request,
        Deposit $deposit
    ): RedirectResponse {

        $this->depositService->reject(
            $deposit,
            $request->user(),
            $request->reason
        );

        return redirect()
            ->route('admin.deposits.show', $deposit)
            ->with(
                'success',
                'Deposit rejected successfully.'
            );
    }
}
