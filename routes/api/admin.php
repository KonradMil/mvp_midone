<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'web']], function () {
    Route::post('projects/get', [ChallengeController::class, 'adminGetProjects']);
    Route::post('projects/get', [ChallengeController::class, 'adminGetUsers']);
});
