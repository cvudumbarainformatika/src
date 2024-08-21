<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/playground', function () {
    event(new \App\Events\PlaygroundEvent());
    return null;
});
Route::get('/notif', function () {
    event(new \App\Events\NotifEvent('oooi'));
    return 'null';
});
Route::get('/auth/{provider}/redirect', [AuthController::class, 'redirectGoogle']);
Route::get('/auth/{provider}/callback', [AuthController::class, 'callbackGoogle']);
Route::get('/autogen', function () {
    return 'ookk';
});
