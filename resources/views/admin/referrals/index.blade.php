@extends('admin.layout')

@section('content')

    <div class="card">

        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">

                <h3>

                    مدیریت دعوت‌ها

                </h3>

                <form class="d-flex gap-2">

                    <input
                        class="form-control"
                        name="search"
                        placeholder="جستجو..."
                        value="{{ request('search') }}"
                    >

                    <select
                        name="status"
                        class="form-select"
                    >

                        <option value="">

                            همه

                        </option>

                        <option
                            value="pending"
                            @selected(request('status')=='pending')
                        >

                            Pending

                        </option>

                        <option
                            value="completed"
                            @selected(request('status')=='completed')
                        >

                            Completed

                        </option>

                        <option
                            value="rewarded"
                            @selected(request('status')=='rewarded')
                        >

                            Rewarded

                        </option>

                    </select>

                    <button
                        class="btn btn-primary"
                    >

                        جستجو

                    </button>

                </form>

            </div>

            <table class="table table-hover align-middle">

                <thead>

                <tr>

                    <th>#</th>

                    <th>دعوت‌کننده</th>

                    <th>دعوت‌شونده</th>

                    <th>کد دعوت</th>

                    <th>وضعیت</th>

                    <th>تاریخ</th>

                </tr>

                </thead>

                <tbody>

                @foreach($referrals as $referral)

                    <tr>

                        <td>

                            {{ $referral->id }}

                        </td>

                        <td>

                            {{ $referral->referrer?->first_name }}

                        </td>

                        <td>

                            {{ $referral->referred?->first_name }}

                        </td>

                        <td>

                            {{ $referral->referral_code }}

                        </td>

                        <td>

                            @switch($referral->status)

                                @case('pending')

                                    <span class="badge bg-warning">

                                    Pending

                                </span>

                                    @break

                                @case('completed')

                                    <span class="badge bg-info">

                                    Completed

                                </span>

                                    @break

                                @case('rewarded')

                                    <span class="badge bg-success">

                                    Rewarded

                                </span>

                                    @break

                            @endswitch

                        </td>

                        <td>

                            {{ verta()->formatJalaliDatetime($referral->created_at) }}

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

            {{ $referrals->links() }}

        </div>

    </div>

@endsection
