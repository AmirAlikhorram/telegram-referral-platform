@extends('admin.layout')

@section('content')

    <div class="row g-4">

        <div class="col-lg-3">

            <div class="card stat-card bg-primary text-white">

                <div class="card-body">

                    <i class="fa fa-users stat-icon"></i>

                    <h6>کاربران</h6>

                    <h2>

                        {{ $stats['users'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card stat-card bg-success text-white">

                <div class="card-body">

                    <i class="fa fa-user-check stat-icon"></i>

                    <h6>کاربران فعال</h6>

                    <h2>

                        {{ $stats['active_users'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card stat-card bg-warning text-dark">

                <div class="card-body">

                    <i class="fa fa-user-plus stat-icon"></i>

                    <h6>دعوت‌ها</h6>

                    <h2>

                        {{ $stats['referrals'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card stat-card bg-info text-white">

                <div class="card-body">

                    <i class="fa fa-gift stat-icon"></i>

                    <h6>پاداش‌ها</h6>

                    <h2>

                        {{ $stats['completed_referrals'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card stat-card bg-danger text-white">

                <div class="card-body">

                    <i class="fa fa-hourglass-half stat-icon"></i>

                    <h6>برداشت‌های انتظار</h6>

                    <h2>

                        {{ $stats['pending_withdrawals'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card stat-card bg-secondary text-white">

                <div class="card-body">

                    <i class="fa fa-circle-check stat-icon"></i>

                    <h6>برداشت پرداخت شده</h6>

                    <h2>

                        {{ $stats['paid_withdrawals'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card stat-card bg-dark text-white">

                <div class="card-body">

                    <i class="fa fa-money-bill-transfer stat-icon"></i>

                    <h6>تراکنش‌ها</h6>

                    <h2>

                        {{ $stats['wallet_transactions'] }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card stat-card bg-success text-white">

                <div class="card-body">

                    <i class="fa fa-wallet stat-icon"></i>

                    <h6>موجودی کل</h6>

                    <h2>

                        {{ number_format($stats['wallet_balance'],2) }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

@endsection
