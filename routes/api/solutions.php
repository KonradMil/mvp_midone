<?php

use App\Http\Controllers\SolutionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'solution', 'middleware' => 'auth:sanctum'], function () {
    Route::post('images/store', [SolutionController::class, 'storeFile']);
    Route::post('robots', [SolutionController::class, 'getRobots']);
    Route::post('files/get', [SolutionController::class, 'getSolutionFiles']);
    Route::post('save/robot', [SolutionController::class, 'saveRobot']);
    Route::post('filter', [SolutionController::class, 'deleteSolutionsNull']);
    Route::post('user/filter', [SolutionController::class, 'filterChallengeSolutions']);
    Route::post('user/get/archive', [SolutionController::class, 'getUserSolutionsArchive']);
    Route::post('accept', [SolutionController::class, 'acceptSolution']);
    Route::post('reject', [SolutionController::class, 'rejectSolution']);
    Route::post('user/get', [SolutionController::class, 'getUserSolutionsFiltered']);
    Route::post('save/description', [SolutionController::class, 'saveDescription']);
    Route::post('check-team', [SolutionController::class, 'checkTeam']);
    Route::post('filter-member', [SolutionController::class, 'filterMember']);
    Route::post('get/unity', [SolutionController::class, 'getUserSolutionUnity']);
    Route::post('user/create', [SolutionController::class, 'createSolution']);
    Route::post('create', [SolutionController::class, 'create']);
    Route::post('save/financials/{financial}', [SolutionController::class, 'saveSolutionFinancials']);
    Route::post('user/save/teams/{solution}', [SolutionController::class, 'saveSolutionTeams']);
    Route::post('user/get/solutions/challenge/{challenge}', [SolutionController::class, 'getUserSolutionsChallenge']);
    Route::post('user/get/solutions/project', [SolutionController::class, 'getUserSolutionsProject']);
    Route::post('save', [SolutionController::class, 'saveSolution']);
    Route::post('user/like', [SolutionController::class, 'likeSolution']);
    Route::post('user/dislike', [SolutionController::class, 'dislikeSolution']);
    Route::post('publish', [SolutionController::class, 'publish']);
    Route::post('unpublish', [SolutionController::class, 'unpublish']);
    Route::post('delete', [SolutionController::class, 'delete']);
    Route::post('file/delete', [SolutionController::class, 'deleteFile']);
    Route::post('estimate/save', [SolutionController::class, 'estimateSave']);
    Route::post('financial-analyses/save', [SolutionController::class, 'financialAnalysesSave']);
    Route::post('operational-analyses/save', [SolutionController::class, 'operationalAnalysesSave']);
    Route::post('operational-analyses/get', [SolutionController::class, 'operationalAnalysesGet']);
    Route::post('financial-analyses/get', [SolutionController::class, 'financialAnalysesGet']);
    Route::post('estimate/get', [SolutionController::class, 'estimateGet']);
    Route::post('{solution_id}/files/save', [SolutionController::class, 'saveFiles']);
    Route::post('all/get', [SolutionController::class, 'getChallengeSolutions']);
    Route::get('{user_id}/all', [SolutionController::class, 'getAllSolutionsUser']);
    Route::get('{user_id}/challenge/solutions', [SolutionController::class, 'getChallengeSolutionsByChallengeName']);
});

//Route::group(['prefix' => 'solution', 'middleware' => 'auth:sanctum'], function () {
//    Route::post('create', [SolutionController::class, 'create']);
//});
