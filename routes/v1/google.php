<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::group([
    // 'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::get('/{provider}/redirect', [AuthController::class, 'redirectGoogle']);
    Route::get('/{provider}/callback', [AuthController::class, 'callbackGoogle']);
});
