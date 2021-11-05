<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'report', 'middleware' => 'auth:sanctum'], function () {
    Route::post('user/get', [ReportController::class, 'getUserReports']);
    Route::get('{user_id}/admin', [ReportController::class, 'getAdminReports']);
    Route::post('user/show', [ReportController::class, 'getReport']);
    Route::post('user/create', [ReportController::class, 'createReport']);
    Route::post('user/delete', [ReportController::class, 'deleteReport']);
    Route::post('files/store', [ReportController::class, 'storeFile']);
});

Route::post('report/show', [ReportController::class, 'getReport']);
