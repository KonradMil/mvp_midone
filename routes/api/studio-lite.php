<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\FreeSavesController;
use App\Http\Controllers\RobochallengeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'playground', 'middleware' => 'auth:sanctum'], function () {
    Route::get('saves', [FreeSavesController::class, 'getSaves']);
    Route::get('save/{id}', [FreeSavesController::class, 'getSave']);
    Route::post('save/data', [ChallengeController::class, 'saveFreeSave']);
    Route::post('save/data/get', [RobochallengeController::class, 'getRoboData']);
    Route::post('saves/delete', [FreeSavesController::class, 'deleteSave']);
    Route::post('saves/grade', [RobochallengeController::class, 'gradeSave']);
    Route::post('saves/reset', [RobochallengeController::class, 'resetSave']);
    Route::post('robochallenge/go', [RobochallengeController::class, 'goToRoboChallengeSave']);
});
