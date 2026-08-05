<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramWebhookController;
use App\Services\Telegram\TelegramService;
use App\Http\Controllers\Admin\WithdrawalController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReferralController;
use App\Http\Controllers\Admin\BroadcastController;
use App\Http\Controllers\Admin\DepositController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/telegram/webhook', [TelegramWebhookController::class, 'handle'])
    ->name('telegram.webhook');
                                //-------------admin Routes-----------------------------


Route::prefix('admin')
    ->name('admin')
    ->group(function () {
//        ----------------------------deposits-----------------------------
//        Route::get(
//            '/deposits',
//            [DepositController::class, 'index']
//        )->name('deposits.index');
//
//        Route::get(
//            '/deposits/{deposit}',
//            [DepositController::class, 'show']
//        )->name('deposits.show');
//
//        Route::post(
//            '/deposits/{deposit}/approve',
//            [DepositController::class, 'approve']
//        )->name('deposits.approve');
//
//        Route::post(
//            '/deposits/{deposit}/reject',
//            [DepositController::class, 'reject']
//        )->name('deposits.reject');

//        ----------------------------withdrawals-----------------------------
//        Route::get(
//            '/withdrawals',
//            [WithdrawalController::class, 'index']
//        )->name('withdrawals.index');
//
//        Route::post(
//            '/withdrawals/{withdrawal}/approve',
//            [WithdrawalController::class, 'approve']
//        )->name('withdrawals.approve');
//
//        Route::post(
//            '/withdrawals/{withdrawal}/reject',
//            [WithdrawalController::class, 'reject']
//        )->name('withdrawals.reject');
//
//        Route::post(
//            '/withdrawals/{withdrawal}/paid',
//            [WithdrawalController::class, 'paid']
//        )->name('withdrawals.paid');
//        ---------------------------Dashboard---------------------------------------
        Route::get(
            '/legacy-admin',
            [DashboardController::class, 'index']
        )->name('dashboard');


//        -------------------------settings----------------------------
//        Route::get(
//            '/settings',
//            [SettingController::class, 'index']
//        )->name('settings.index');
//
//        Route::post(
//            '/settings',
//            [SettingController::class, 'update']
//        )->name('settings.update');
//        ----------------------------users----------------------------------------
//        Route::get('/users', [UserController::class, 'index'])
//            ->name('users.index');
//
//        Route::get('/users/{user}', [UserController::class, 'show'])
//            ->name('users.show');
//
//        Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
//            ->name('users.toggle-status');
//        -----------referrals--------------------------
//        Route::get(
//            '/referrals',
//            [ReferralController::class, 'index']
//        )->name('referrals.index');
////        -----------------------------------BroadCasts----------------------------------
//        Route::get(
//            '/broadcasts',
//            [BroadcastController::class,'index']
//        )->name('broadcasts.index');
//
//        Route::post(
//            '/broadcasts',
//            [BroadcastController::class,'send']
//        )->name('broadcasts.send');
//
//    });
//Route::get('/test', function (TelegramService $telegram) {
//    dd($telegram);
//});
    });
