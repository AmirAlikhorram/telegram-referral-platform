@extends('admin.layout')

@section('content')

    <div class="card">

        <div class="card-body">

            <h3>

                اطلاعات کاربر

            </h3>

            <hr>

            <table class="table">

                <tr>

                    <th>ID</th>

                    <td>{{ $user->id }}</td>

                </tr>

                <tr>

                    <th>نام</th>

                    <td>{{ $user->first_name }}</td>

                </tr>

                <tr>

                    <th>نام کاربری</th>

                    <td>{{ '@'.$user->telegram_username }}</td>

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

                    <th>موجودی</th>

                    <td>

                        {{ number_format($user->wallet_balance,2) }}

                    </td>

                </tr>

                <tr>

                    <th>وضعیت</th>

                    <td>

                        {{ $user->status }}

                    </td>

                </tr>

            </table>

            <form
                method="POST"
                action="{{ route('admin.users.toggle-status',$user) }}"
            >

                @csrf

                <button
                    class="btn btn-warning"
                >

                    @if($user->status=='active')

                        مسدود کردن

                    @else

                        فعال کردن

                    @endif

                </button>

            </form>

        </div>

    </div>

@endsection
