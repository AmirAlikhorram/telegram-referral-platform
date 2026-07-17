<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('telegram_username', 'like', "%{$search}%")
                    ->orWhere('telegram_id', 'like', "%{$search}%");

            });

        }

        $users = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.users.index',
            compact('users')
        );
    }

    public function show(User $user)
    {
        return view(
            'admin.users.show',
            compact('user')
        );
    }

    public function toggleStatus(User $user)
    {
        $user->update([
            'status' => $user->status === 'active'
                ? 'blocked'
                : 'active',
        ]);

        return back()->with(
            'success',
            'وضعیت کاربر بروزرسانی شد.'
        );
    }
}
