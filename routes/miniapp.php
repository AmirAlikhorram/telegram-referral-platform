<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MiniApp\MiniAppController;


Route::prefix('miniapp')
    ->name('miniapp.')
    ->group(function () {

        Route::get('/', [
            MiniAppController::class,
            'index'
        ])->name('index');

    });
