<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChallengeController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'web']], function () {
    Route::get('projects/get', [AdminController::class, 'adminGetProjects']);
    Route::get('users/get', [ChallengeController::class, 'adminGetUsers']);
});
