@extends('admin.layout')

@section('content')

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card mb-4">

        <div class="card-body">

            <h3>

                ارسال پیام همگانی

            </h3>

            <form
                method="POST"
                action="{{ route('admin.broadcasts.send') }}"
            >

                @csrf

                <textarea
                    name="message"
                    class="form-control"
                    rows="7"
                    placeholder="متن پیام..."
                    required
                ></textarea>

                <button
                    class="btn btn-primary mt-3"
                >

                    ارسال

                </button>

            </form>

        </div>

    </div>

    <div class="card">

        <div class="card-body">

            <table class="table">

                <thead>

                <tr>

                    <th>#</th>

                    <th>ارسال موفق</th>

                    <th>ارسال ناموفق</th>

                    <th>تاریخ</th>

                </tr>

                </thead>

                <tbody>

                @foreach($broadcasts as $broadcast)

                    <tr>

                        <td>

                            {{ $broadcast->id }}

                        </td>

                        <td>

                            {{ $broadcast->sent }}

                        </td>

                        <td>

                            {{ $broadcast->failed }}

                        </td>

                        <td>

                            {{ $broadcast->created_at }}

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

            {{ $broadcasts->links() }}

        </div>

    </div>

@endsection
