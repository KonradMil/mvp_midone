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
    Route::post('local-vision/accept-report', [ProjectController::class, 'acceptReport']);
    Route::post('local-vision/reject', [ProjectController::class, 'rejectLocalVision']);
    Route::post('local-vision/reject-report', [ProjectController::class, 'rejectReport']);
    Route::post('financial-details/save', [ProjectController::class, 'saveFinancialDetails']);
    Route::post('technical-details/save', [ProjectController::class, 'saveTechnicalDetails']);
    Route::post('project-offer/accept', [ProjectController::class, 'acceptOffer']);
    Route::post('project-offer/reject', [ProjectController::class, 'rejectOffer']);
    Route::post('technical-details/accept', [ProjectController::class, 'acceptTechnicalDetails']);
    Route::post('technical-details/reject', [ProjectController::class, 'rejectTechnicalDetails']);
    Route::post('technical-details/get-new', [ProjectController::class, 'getNewTechnicalDetails']);
    Route::post('financial-details/accept', [ProjectController::class, 'acceptFinancialDetails']);
    Route::post('financial-details/reject', [ProjectController::class, 'rejectFinancialDetails']);
    Route::post('financial-details/get-new', [ProjectController::class, 'getNewFinancialDetails']);
    Route::post('solution/get', [ProjectController::class, 'getProjectSolution']);
    Route::post('investor-integrator/get', [ProjectController::class, 'getInvestorAndIntegrator']);
    Route::post('visit-date/save', [ProjectController::class, 'saveVisitDate']);
    Route::post('visit-date/get', [ProjectController::class, 'getVisitDate']);
    Route::post('visit-date/accept', [ProjectController::class, 'acceptVisitDate']);
    Route::post('visit-date/reject', [ProjectController::class, 'rejectVisitDate']);
    Route::post('visit-date/cancel', [ProjectController::class, 'cancelVisitDate']);
    Route::post('visit-date/end', [ProjectController::class, 'endVisitDate']);
    Route::post('visit-date/delete', [ProjectController::class, 'deleteVisitDate']);
    Route::post('offer/get', [ProjectController::class, 'getOffersProject']);
    Route::post('offer/integrator/get', [ProjectController::class, 'getOffersProjectIntegrator']);
});


