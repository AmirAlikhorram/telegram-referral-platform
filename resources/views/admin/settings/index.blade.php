@extends('admin.layout')

@section('content')

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <form
        method="POST"
        action="{{ route('admin.settings.update') }}"
    >

        @csrf

        <div class="row">

            <div class="col-md-6">

                <div class="card mb-4">

                    <div class="card-header">

                        🤖 تنظیمات ربات

                    </div>

                    <div class="card-body">

                        <label>

                            Bot Username

                        </label>

                        <input
                            class="form-control mb-3"
                            name="telegram_bot_username"
                            value="{{ $settings['telegram_bot_username'] ?? '' }}"
                        >

                        <label>

                            Channel Username

                        </label>

                        <input
                            class="form-control mb-3"
                            name="telegram_required_channel"
                            value="{{ $settings['telegram_required_channel'] ?? '' }}"
                        >

                        <label>

                            Channel URL

                        </label>

                        <input
                            class="form-control"
                            name="telegram_channel_url"
                            value="{{ $settings['telegram_channel_url'] ?? '' }}"
                        >

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="card mb-4">

                    <div class="card-header">

                        💰 تنظیمات مالی

                    </div>

                    <div class="card-body">

                        <label>

                            Referral Reward

                        </label>

                        <input
                            type="number"
                            step="0.01"
                            class="form-control mb-3"
                            name="referral_reward"
                            value="{{ $settings['referral_reward'] ?? 10 }}"
                        >

                        <label>

                            Minimum Withdraw

                        </label>

                        <input
                            type="number"
                            step="0.01"
                            class="form-control"
                            name="minimum_withdraw"
                            value="{{ $settings['minimum_withdraw'] ?? 5 }}"
                        >

                    </div>

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-6">

                <div class="card">

                    <div class="card-header">

                        🚀 وضعیت سیستم

                    </div>

                    <div class="card-body">

                        <div class="form-check form-switch mb-3">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="bot_enabled"
                                value="1"
                                @checked(($settings['bot_enabled'] ?? 1)==1)
                            >

                            <label class="form-check-label">

                                Bot Enabled

                            </label>

                        </div>

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="maintenance_mode"
                                value="1"
                                @checked(($settings['maintenance_mode'] ?? 0)==1)
                            >

                            <label class="form-check-label">

                                Maintenance Mode

                            </label>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="card">

                    <div class="card-header">

                        📊 اطلاعات سیستم

                    </div>

                    <div class="card-body">

                        <table class="table table-borderless">

                            <tr>

                                <td>

                                    Laravel

                                </td>

                                <td>

                                    {{ app()->version() }}

                                </td>

                            </tr>

                            <tr>

                                <td>

                                    PHP

                                </td>

                                <td>

                                    {{ PHP_VERSION }}

                                </td>

                            </tr>

                            <tr>

                                <td>

                                    Users

                                </td>

                                <td>

                                    {{ \App\Models\User::count() }}

                                </td>

                            </tr>

                            <tr>

                                <td>

                                    Referrals

                                </td>

                                <td>

                                    {{ \App\Models\Referral::count() }}

                                </td>

                            </tr>

                            <tr>

                                <td>

                                    Withdrawals

                                </td>

                                <td>

                                    {{ \App\Models\WithdrawalRequest::count() }}

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        <div class="mt-4">

            <button
                class="btn btn-success btn-lg"
            >

                💾 ذخیره تنظیمات

            </button>

        </div>

    </form>

@endsection
