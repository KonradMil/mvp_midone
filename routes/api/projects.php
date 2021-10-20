<?php

use App\Http\Controllers\ProjectCommunicationsController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectRisksController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'projects', 'middleware' => 'auth:sanctum'], function () {
    Route::get('{id}/card', [ProjectController::class, 'getProjectCard']);
    Route::post('{project_id}/visit-date/save', [ProjectController::class, 'saveVisitDate']);
    Route::post('{project_id}/visit-date/{id}/save_members', [ProjectController::class, 'saveMembersVisitDate']);
    Route::get('{project_id}/visit-date', [ProjectController::class, 'getVisitDate']);
    Route::post('{project_id}/visit-date/{id}/accept', [ProjectController::class, 'acceptVisitDate']);
    Route::post('{project_id}/visit-date/{id}/reject', [ProjectController::class, 'rejectVisitDate']);
    Route::post('{project_id}/visit-date/{id}/cancel', [ProjectController::class, 'cancelVisitDate']);
    Route::post('{project_id}/visit-date/{id}/delete', [ProjectController::class, 'deleteVisitDate']);
    Route::post('{project_id}/files/save', [ProjectController::class, 'saveFiles']);
    Route::get('{project_id}/files', [ProjectController::class, 'getFiles']);
    Route::post('{project_id}/file/delete', [ProjectController::class, 'deleteFile']);
    Route::get('{project_id}/local-vision', [ProjectController::class, 'getLocalVision']);
    Route::post('{project_id}/local-vision/save', [ProjectController::class, 'saveLocalVision']);
    Route::post('{project_id}/local-vision/{id}/accept', [ProjectController::class, 'acceptReport']);
    Route::post('{project_id}/local-vision/{id}/reject', [ProjectController::class, 'rejectReport']);
    Route::post('{project_id}/local-vision/{id}/delete', [ProjectController::class, 'deleteReport']);
    Route::post('{project_id}/local-vision/end', [ProjectController::class, 'endLocalVision']);
    Route::post('{project_id}/local-vision/{id}/save_comment', [ProjectController::class, 'saveCommentLocalVision']);
    Route::get('{challenge_id}/technical-details', [ProjectController::class, 'getTechnicalDetails']);
    Route::get('{challenge_id}/financial-details', [ProjectController::class, 'getFinancialDetails']);
    Route::post('{challenge_id}/technical-details/save', [ProjectController::class, 'saveTechnicalDetails']);
    Route::post('{challenge_id}/financial-details/save', [ProjectController::class, 'saveFinancialDetails']);
    Route::post('{project_id}/technical-details/accept', [ProjectController::class, 'acceptTechnicalDetails']);
    Route::post('{project_id}/technical-details/reject', [ProjectController::class, 'rejectTechnicalDetails']);
    Route::post('{project_id}/financial-details/accept', [ProjectController::class, 'acceptFinancialDetails']);
    Route::post('{project_id}/financial-details/reject', [ProjectController::class, 'rejectFinancialDetails']);
    Route::get('{challenge_id}/offers', [ProjectController::class, 'getOffersProject']);
    Route::get('{challenge_id}/offers/integrator', [ProjectController::class, 'getOffersProjectIntegrator']);
    Route::post('{project_id}/offer/{id}/accept', [ProjectController::class, 'acceptOffer']);
    Route::post('{project_id}/offer/{id}/reject', [ProjectController::class, 'rejectOffer']);
    Route::get('{challenge_id}/solution', [ProjectController::class, 'getProjectSolution']);
    Route::get('{challenge_id}/investor-integrator', [ProjectController::class, 'getInvestorAndIntegrator']);
    Route::post('visit-date/end', [ProjectController::class, 'endVisitDate']);
    Route::get('{project_id}/communications/integrator', [ProjectCommunicationsController::class, 'getIntegratorCommunications']);
    Route::get('{project_id}/communications/investor', [ProjectCommunicationsController::class, 'getInvestorCommunications']);
    Route::post('{project_id}/communication/save', [ProjectCommunicationsController::class, 'saveCommunicationPlan']);
    Route::post('{project_id}/communication/{id}/delete', [ProjectCommunicationsController::class, 'deleteCommunicationPlan']);
    Route::post('{project_id}/communication/{id}/accept', [ProjectCommunicationsController::class, 'acceptProjectCommunicationPlan']);
    Route::get('{project_id}/risks', [ProjectRisksController::class, 'getRisks']);
    Route::post('{project_id}/risk/save', [ProjectRisksController::class, 'saveRisk']);
    Route::post('{project_id}/risk/{id}/delete', [ProjectRisksController::class, 'deleteRisk']);
    Route::post('{project_id}/risk/{id}/accept', [ProjectRisksController::class, 'acceptProjectRisk']);
});


