<?php

use App\Http\Controllers\Api\v1\ReportController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'report'
], function () {
    Route::get('/send-notif-get-report', [ReportController::class, 'sendNotifGetReport']);
    Route::get('/get-saved-report', [ReportController::class, 'getSavedReport']);
});
