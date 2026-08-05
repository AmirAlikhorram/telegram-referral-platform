@extends('admin.layout')

@section('content')

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h3>واریزی ها</h3>

            <span class="badge bg-primary">
            {{ $deposits->total() }} Records
        </span>

        </div>

        <table class="table table-bordered table-striped align-middle">

            <thead>

            <tr>

                <th>ID</th>

                <th>کاربر</th>

                <th>مقدار</th>

                <th>شبکه</th>

                <th>وضعیت</th>

                <th>تاریخ</th>

                <th width="120">اطلاعات</th>

            </tr>

            </thead>

            <tbody>

            @forelse($deposits as $deposit)

                <tr>

                    <td>{{ $deposit->id }}</td>

                    <td>

                        {{ $deposit->user->first_name }}

                        <br>

                        <small>

                            {{ $deposit->user->telegram_id }}

                        </small>

                    </td>

                    <td>

                        {{ number_format($deposit->amount,2) }}

                        USDT

                    </td>

                    <td>

                        {{ $deposit->network }}

                    </td>

                    <td>

                        @switch($deposit->status)

                            @case('pending')

                                <span class="badge bg-warning">
                                Pending
                            </span>

                                @break

                            @case('approved')

                                <span class="badge bg-success">
                                Approved
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

                        {{ $deposit->created_at }}

                    </td>

                    <td>

                        <a

                            href="{{ route('admin.deposits.show',$deposit) }}"

                            class="btn btn-sm btn-primary">

                            View

                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7">

                        No deposits found.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

        {{ $deposits->links() }}

    </div>

@endsection
