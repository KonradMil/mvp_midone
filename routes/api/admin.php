<?php

use App\Http\Controllers\ChallengeController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::post('projects/get', [ChallengeController::class, 'adminGetProjects']);
    Route::post('projects/get', [ChallengeController::class, 'adminGetUsers']);
});
