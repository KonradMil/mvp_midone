<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'projects', 'middleware' => 'auth:sanctum'], function () {
    Route::post('get/card', [ProjectController::class, 'getCardData']);
    Route::post('local-vision/save', [ProjectController::class, 'saveLocalVision']);
    Route::post('local-vision/get', [ProjectController::class, 'getLocalVision']);
    Route::post('local-vision/delete', [ProjectController::class, 'deleteLocalVision']);
    Route::post('local-vision/accept', [ProjectController::class, 'acceptLocalVision']);
    Route::post('financial-details/save', [ProjectController::class, 'saveFinancialDetails']);
    Route::post('technical-details/save', [ProjectController::class, 'saveTechnicalDetails']);
    Route::post('project-offer/accept', [ProjectController::class, 'acceptOffer']);
    Route::post('details/accept', [ProjectController::class, 'acceptDetails']);
});


