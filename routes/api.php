<?php

use App\Helpers\Routes\RouteHelper;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\v1\NotifController;
use App\Http\Controllers\Api\v1\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * API Auth Routes
 */

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    //
});

// Route::post('send-message', [NotifController::class, 'storeNotif']);

Route::middleware('org.dalam')
    ->group(function () {
        Route::post('send-message', [NotifController::class, 'storeNotif']);
        Route::post('get-messages-not-read', [NotifController::class, 'getNotif']);
        Route::post('update-message-by-id', [NotifController::class, 'updateNotif']);
        Route::post('report', [ReportController::class, 'storeReport']);
    });

Route::prefix('v1')->group(function () {
    RouteHelper::includeRouteFiles(__DIR__ . '/v1');
});
