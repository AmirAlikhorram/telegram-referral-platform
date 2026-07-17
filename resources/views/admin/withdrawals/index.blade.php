@extends('admin.layout')

@section('content')

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card">

        <div class="card-body">

            <h3 class="mb-4">

                مدیریت برداشت‌ها

            </h3>

            <form class="row mb-4">

                <div class="col-md-4">

                    <input
                        name="search"
                        class="form-control"
                        placeholder="جستجوی کاربر..."
                        value="{{ request('search') }}"
                    >

                </div>

                <div class="col-md-3">

                    <select
                        name="status"
                        class="form-select">

                        <option value="">همه</option>

                        <option value="pending"
                            @selected(request('status')=='pending')>

                            Pending

                        </option>

                        <option value="approved"
                            @selected(request('status')=='approved')>

                            Approved

                        </option>

                        <option value="paid"
                            @selected(request('status')=='paid')>

                            Paid

                        </option>

                        <option value="rejected"
                            @selected(request('status')=='rejected')>

                            Rejected

                        </option>

                    </select>

                </div>

                <div class="col-md-2">

                    <button class="btn btn-primary w-100">

                        جستجو

                    </button>

                </div>

            </form>

            <table class="table table-striped table-hover">

                <thead>

                <tr>

                    <th>#</th>

                    <th>کاربر</th>

                    <th>مبلغ</th>

                    <th>کیف پول</th>

                    <th>وضعیت</th>

                    <th>عملیات</th>

                </tr>

                </thead>

                <tbody>

                @foreach($withdrawals as $withdrawal)

                    <tr>

                        <td>

                            {{ $withdrawal->id }}

                        </td>

                        <td>

                            {{ $withdrawal->user->first_name }}

                            <br>

                            <small>

                                {{ '@'.$withdrawal->user->telegram_username }}

                            </small>

                        </td>

                        <td>

                            {{ number_format($withdrawal->amount,2) }}

                        </td>

                        <td>

                            <code>

                                {{ $withdrawal->wallet_address }}

                            </code>

                        </td>

                        <td>

                            @switch($withdrawal->status)

                                @case('pending')

                                    <span class="badge bg-warning">

Pending

</span>

                                    @break

                                @case('approved')

                                    <span class="badge bg-info">

Approved

</span>

                                    @break

                                @case('paid')

                                    <span class="badge bg-success">

Paid

</span>

                                    @break

                                @case('rejected')

                                    <span class="badge bg-danger">

Rejected

</span>

                                    @break

                            @endswitch

                        </td>

                        <td>

                            @if($withdrawal->status=='pending')

                                <form
                                    method="POST"
                                    action="{{ route('admin.withdrawals.approve',$withdrawal) }}"
                                    class="d-inline">

                                    @csrf

                                    <button
                                        class="btn btn-success btn-sm">

                                        ✓ تایید

                                    </button>

                                </form>

                                <form
                                    method="POST"
                                    action="{{ route('admin.withdrawals.reject',$withdrawal) }}"
                                    class="d-inline">

                                    @csrf

                                    <button
                                        class="btn btn-danger btn-sm">

                                        ✕ رد

                                    </button>

                                </form>

                            @endif

                            @if($withdrawal->status=='approved')

                                <form
                                    method="POST"
                                    action="{{ route('admin.withdrawals.paid',$withdrawal) }}"
                                    class="d-inline">

                                    @csrf

                                    <button
                                        class="btn btn-primary btn-sm">

                                        💸 پرداخت شد

                                    </button>

                                </form>

                            @endif

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

            {{ $withdrawals->links() }}

        </div>

    </div>

@endsection
