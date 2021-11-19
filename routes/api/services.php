<?php

use App\Http\Controllers\Admin\ServicesController;

Route::group(['prefix' => 'saas'], function () {
    Route::post('{organization}/data', [ServicesController::class, 'getServiceData']);
    Route::post('register/{organization}', [ServicesController::class, 'registerServiceUser']);
    Route::post('login/{organization}', [ServicesController::class, 'logInServiceUser']);
});
