@extends('admin.layout')

@section('content')

    <div class="card">

        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">

                <h4>

                    کاربران

                </h4>

                <form>

                    <input
                        type="text"
                        class="form-control"
                        name="search"
                        placeholder="جستجو..."
                        value="{{ request('search') }}"
                    >

                </form>

            </div>

            <table class="table table-hover align-middle">

                <thead>

                <tr>

                    <th>#</th>

                    <th>نام</th>

                    <th>تلگرام</th>

                    <th>موجودی</th>

                    <th>وضعیت</th>

                    <th></th>

                </tr>

                </thead>

                <tbody>

                @foreach($users as $user)

                    <tr>

                        <td>

                            {{ $user->id }}

                        </td>

                        <td>

                            {{ $user->first_name }}

                        </td>

                        <td>

                            @if($user->telegram_username)

                                {{ '@'.$user->telegram_username }}

                            @else

                                -

                            @endif

                        </td>

                        <td>

                            {{ number_format($user->wallet?->reward_balance,2) }}

                        </td>

                        <td>

                            @if($user->status=='active')

                                <span class="badge bg-success">

                                فعال

                            </span>

                            @else

                                <span class="badge bg-danger">

                                مسدود

                            </span>

                            @endif

                        </td>

                        <td>

                            <a
                                href="{{ route('admin.users.show',$user) }}"
                                class="btn btn-primary btn-sm"
                            >

                                مشاهده

                            </a>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

            {{ $users->links() }}

        </div>

    </div>

@endsection
