<?php

use App\Http\Controllers\Admin\ShowroomController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'web']], function () {
    Route::group(['prefix' => 'projects'], function () {

    });
    Route::group(['prefix' => 'users'], function () {

    });
    Route::group(['prefix' => 'showrooms'], function () {
        Route::get('get', [ShowroomController::class, 'index']);
        Route::post('save', [ShowroomController::class, 'saveShowroom']);
    });
});
