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
    Route::post('local-vision/reject', [ProjectController::class, 'rejectLocalVision']);
    Route::post('financial-details/save', [ProjectController::class, 'saveFinancialDetails']);
    Route::post('technical-details/save', [ProjectController::class, 'saveTechnicalDetails']);
    Route::post('project-offer/accept', [ProjectController::class, 'acceptOffer']);
    Route::post('project-offer/reject', [ProjectController::class, 'rejectOffer']);
    Route::post('technical-details/accept', [ProjectController::class, 'acceptTechnicalDetails']);
    Route::post('technical-details/reject', [ProjectController::class, 'rejectTechnicalDetails']);
    Route::post('financial-details/accept', [ProjectController::class, 'acceptFinancialDetails']);
    Route::post('financial-details/reject', [ProjectController::class, 'rejectFinancialDetails']);
});


