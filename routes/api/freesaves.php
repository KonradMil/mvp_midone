<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\FreeSavesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'freesaves', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('{freesave_id}/unity', [FreeSavesController::class, 'getSingleSave']);
    Route::post('many/unity/get', [ChallengeController::class, 'getManySaves']);
    Route::post('{freesave_id/save', [ChallengeController::class, 'saveData']);
    Route::post('get/good/projects', [ChallengeController::class, 'getUserChallengesGoodProjects']);
});
