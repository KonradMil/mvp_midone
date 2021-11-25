<?php


use App\Http\Controllers\Admin\ShowroomController;

Route::group(['prefix' => 'showroom'], function () {
    Route::get('{organization}/data', [ShowroomController::class, 'getShowroomData']);
    Route::get('part', [ShowroomController::class, 'getPartData']);
    Route::post('login/{organization}', [ShowroomController::class, 'logInShowroomUser']);
});
