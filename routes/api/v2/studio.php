<?php

use App\Http\Controllers\Api\v2\StudioController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v2/studio'], function () {
    Route::post('/get_challenge', [StudioController::class, 'getChallengeSave']);
    Route::post('/get_solution', [StudioController::class, 'getSolutionSave']);
});
