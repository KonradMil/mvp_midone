<?php


use App\Http\Controllers\Admin\ShowroomController;

Route::group(['prefix' => 'showroom'], function () {
    Route::post('{organization}/data', [ShowroomController::class, 'getShowroomData']);
    Route::post('login/{organization}', [ShowroomController::class, 'logInShowroomUser']);
});
