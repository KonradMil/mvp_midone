<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::post('projects/get', [ChallengeController::class, 'adminGetProjects']);
    Route::post('projects/get', [ChallengeController::class, 'adminGetUsers']);
    Route::get('impersonate', [UserController::class, 'impersonate']);
});
