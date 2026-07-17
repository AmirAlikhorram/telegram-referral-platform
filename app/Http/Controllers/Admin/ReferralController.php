<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use Illuminate\Http\Request;
use Hekmatinasser\Verta\Verta;

class ReferralController extends Controller
{
    public function index(Request $request)
    {
        $query = Referral::with([
            'referrer',
            'referred',
        ]);

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }

        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas(
                'referrer',
                function ($q) use ($search) {

                    $q->where(
                        'first_name',
                        'like',
                        "%{$search}%"
                    )->orWhere(
                        'telegram_username',
                        'like',
                        "%{$search}%"
                    );

                }
            );

        }

        $referrals = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view(
            'admin.referrals.index',
            compact('referrals')
        );
    }
}
