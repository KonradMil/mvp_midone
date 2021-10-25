<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\FreeSavesController;
use App\Http\Controllers\RobochallengeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'playground', 'middleware' => 'auth:sanctum'], function () {
    Route::get('freesaves/get', [FreeSavesController::class, 'getSaves']);
    Route::post('freesaves/save', [FreeSavesController::class, 'saveFreeSave']);
    Route::post('freesaves/delete', [FreeSavesController::class, 'deleteSave']);
    Route::post('freesaves/add', [FreeSavesController::class, 'addEmptySave']);
});
