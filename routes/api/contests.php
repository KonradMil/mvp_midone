<?php

use App\Http\Controllers\ContestController;

Route::group(['prefix' => 'contest'], function () {
    Route::get('{name_slug}/data', [ContestController::class, 'getContestData']);
    Route::post('register/{name_slug}', [ContestController::class, 'registerUser']);
    Route::post('login/{name_slug}', [ContestController::class, 'logInUser']);
});
