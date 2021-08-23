<?php

use App\Http\Controllers\NotificationsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'notifications', 'middleware' => 'auth:sanctum'], function () {
    Route::post('get', [NotificationsController::class, 'getNotifications']);
    Route::post('delete', [NotificationsController::class, 'deleteNotification']);
    Route::post('set', [NotificationsController::class, 'setReadNotification']);
    Route::post('read-all', [NotificationsController::class, 'allReadNotifications']);
});
