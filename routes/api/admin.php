<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'web']], function () {
    Route::get('projects/get', [ChallengeController::class, 'adminGetProjects']);
    Route::get('users/get', [ChallengeController::class, 'adminGetUsers']);
});
