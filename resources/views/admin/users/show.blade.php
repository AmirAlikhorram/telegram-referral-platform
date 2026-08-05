@extends('admin.layout')

@section('content')

    <div class="container-fluid">

        <div class="row mb-4">

            <div class="col-md-12">

                <div class="card shadow-sm">

                    <div class="card-header d-flex justify-content-between align-items-center">

                        <h4 class="mb-0">
                            پروفایل کاربر
                        </h4>

                        <form method="POST"
                              action="{{ route('admin.users.toggle-status',$user) }}">

                            @csrf

                            <button class="btn btn-warning">

                                @if($user->status=='active')
                                    مسدود کردن
                                @else
                                    فعال کردن
                                @endif

                            </button>

                        </form>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">

                                <table class="table table-bordered">

                                    <tr>
                                        <th width="35%">ID</th>
                                        <td>{{ $user->id }}</td>
                                    </tr>

                                    <tr>
                                        <th>نام</th>
                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                    </tr>

                                    <tr>
                                        <th>Username</th>
                                        <td>{{ $user->telegram_username ? '@'.$user->telegram_username : '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Telegram ID</th>
                                        <td>{{ $user->telegram_id }}</td>
                                    </tr>

                                    <tr>
                                        <th>Referral Code</th>
                                        <td>{{ $user->referral_code }}</td>
                                    </tr>

                                    <tr>
                                        <th>معرف</th>
                                        <td>
                                            {{ $user->referrer?->first_name ?? '-' }}
                                        </td>
                                    </tr>

                                </table>

                            </div>

                            <div class="col-md-6">

                                <table class="table table-bordered">

                                    <tr>
                                        <th width="35%">سطح</th>
                                        <td>{{ $user->level?->name ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Status</th>
                                        <td>{{ ucfirst($user->status) }}</td>
                                    </tr>

                                    <tr>
                                        <th>Professional</th>
                                        <td>
                                            {!! $user->isProfessional()
                                                ? '<span class="badge bg-success">Yes</span>'
                                                : '<span class="badge bg-secondary">No</span>' !!}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Withdraw</th>
                                        <td>
                                            {!! $user->canWithdraw()
                                                ? '<span class="badge bg-success">Enabled</span>'
                                                : '<span class="badge bg-danger">Disabled</span>' !!}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Created</th>
                                        <td>{{ $user->created_at }}</td>
                                    </tr>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="row mb-4">

            <div class="col-md-12">

                <div class="card shadow-sm">

                    <div class="card-header">
                        کیف پول
                    </div>

                    <div class="card-body">

                        <div class="row text-center">

                            <div class="col-md">
                                <h6>Reward</h6>
                                <h4>{{ number_format($user->wallet?->reward_balance ?? 0,8) }}</h4>
                            </div>

                            <div class="col-md">
                                <h6>Withdrawable</h6>
                                <h4>{{ number_format($user->wallet?->withdrawable_balance ?? 0,8) }}</h4>
                            </div>

                            <div class="col-md">
                                <h6>Locked</h6>
                                <h4>{{ number_format($user->wallet?->locked_balance ?? 0,8) }}</h4>
                            </div>

                            <div class="col-md">
                                <h6>Total Earned</h6>
                                <h4>{{ number_format($user->wallet?->total_earned ?? 0,8) }}</h4>
                            </div>

                            <div class="col-md">
                                <h6>Total Withdrawn</h6>
                                <h4>{{ number_format($user->wallet?->total_withdrawn ?? 0,8) }}</h4>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="row mb-4">

            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Deposits</h6>
                        <h2>{{ $user->deposits->count() }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Withdrawals</h6>
                        <h2>{{ $user->withdrawalRequests->count() }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Referrals</h6>
                        <h2>{{ $user->referrals->count() }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Transactions</h6>
                        <h2>{{ $user->wallet?->transactions->count() ?? 0 }}</h2>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection
