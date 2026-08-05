@extends('admin.layout')

@section('content')

    <div class="container">

        <h3>

            Deposit #{{ $deposit->id }}

        </h3>

        <hr>

        <table class="table">

            <tr>

                <th>User</th>

                <td>

                    {{ $deposit->user->first_name }}

                </td>

            </tr>

            <tr>

                <th>Amount</th>

                <td>

                    {{ $deposit->amount }} USDT

                </td>

            </tr>

            <tr>

                <th>Network</th>

                <td>

                    {{ $deposit->network }}

                </td>

            </tr>

            <tr>

                <th>TXID</th>

                <td>

                    {{ $deposit->txid }}

                </td>

            </tr>

            <tr>

                <th>Status</th>

                <td>

                    {{ $deposit->status }}

                </td>

            </tr>

        </table>

        @if($deposit->status=='pending')

            <div class="d-flex gap-2">

                <form

                    method="POST"

                    action="{{ route('admin.deposits.approve',$deposit) }}">

                    @csrf

                    <button

                        class="btn btn-success">

                        Approve

                    </button>

                </form>

                <form

                    method="POST"

                    action="{{ route('admin.deposits.reject',$deposit) }}">

                    @csrf

                    <input

                        type="hidden"

                        name="reason"

                        value="Rejected by admin">

                    <button

                        class="btn btn-danger">

                        Reject

                    </button>

                </form>

            </div>

        @endif

    </div>

@endsection
