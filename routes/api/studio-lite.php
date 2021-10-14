<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\FreeSavesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'playground', 'middleware' => 'auth:sanctum'], function () {
    Route::get('saves', [FreeSavesController::class, 'getSaves']);
    Route::get('save', [FreeSavesController::class, 'getSave']);
    Route::post('save/data', [ChallengeController::class, 'saveFreeSave']);
    Route::post('saves/delete', [FreeSavesController::class, 'deleteSave']);
});
