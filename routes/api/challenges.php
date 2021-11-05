<?php

use App\Http\Controllers\ChallengeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'challenges', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::post('{id}/delete', [ChallengeController::class, 'delete']);
    Route::post('get', [ChallengeController::class, 'getUserChallengesFiltered']);
    Route::post('get/projects', [ChallengeController::class, 'getUserChallengesProjects']);
    Route::post('get/good/projects', [ChallengeController::class, 'getUserChallengesGoodProjects']);
    Route::post('check-team', [ChallengeController::class, 'checkTeam']);
    Route::post('save/description', [ChallengeController::class, 'saveDescription']);
    Route::post('get/followed', [ChallengeController::class, 'getUserChallengesFollowed']);
    Route::post('get/archive', [ChallengeController::class, 'getUserChallengesArchive']);
    Route::post('get/card', [ChallengeController::class, 'getCardData']);
    Route::post('create', [ChallengeController::class, 'createChallenge']);
    Route::post('save', [ChallengeController::class, 'saveChallenge']);
    Route::post('save/details/{technical}', [ChallengeController::class, 'saveChallengeDetails']);
    Route::post('save/financials/{financial}', [ChallengeController::class, 'saveChallengeFinancials']);
    Route::post('save/teams/{challenge}', [ChallengeController::class, 'saveChallengeTeams']);
    Route::post('like', [ChallengeController::class, 'likeChallenge']);
    Route::post('dislike', [ChallengeController::class, 'dislikeChallenge']);
    Route::post('follow', [ChallengeController::class, 'followChallenge']);
    Route::post('unfollow', [ChallengeController::class, 'unfollowChallenge']);
    Route::post('images/store', [ChallengeController::class, 'storeImage']);
    Route::post('publish', [ChallengeController::class, 'publish']);
    Route::post('unpublish', [ChallengeController::class, 'unpublish']);
    Route::post('change/dates', [ChallengeController::class, 'changeDates']);
    Route::post('local-vision/save', [ChallengeController::class, 'localVisionSave']);
    Route::post('get/tab/{category}', [ChallengeController::class, 'getUserChallengesByTab']);
    Route::post('{challenge_id}/file/delete', [ChallengeController::class, 'deleteFile']);
});

// TODO cała grupa poniżej do usunięcia
Route::group(['prefix' => 'challenge', 'middleware' => ['auth:sanctum', 'verified']], function () {
    Route::post('delete', [ChallengeController::class, 'delete']);
    Route::post('user/get', [ChallengeController::class, 'getUserChallengesFiltered']);
    Route::post('user/get/projects', [ChallengeController::class, 'getUserChallengesProjects']);
    Route::post('user/get/good/projects', [ChallengeController::class, 'getUserChallengesGoodProjects']);
    Route::post('check-team', [ChallengeController::class, 'checkTeam']);
    Route::post('user/save/description', [ChallengeController::class, 'saveDescription']);
    Route::post('get/followed', [ChallengeController::class, 'getUserChallengesFollowed']);
    Route::post('get/archive', [ChallengeController::class, 'getUserChallengesArchive']);
    Route::post('user/get/card', [ChallengeController::class, 'getCardData']);
    Route::post('user/create', [ChallengeController::class, 'createChallenge']);
    Route::post('user/save', [ChallengeController::class, 'saveChallenge']);
    Route::post('user/save/details/{technical}', [ChallengeController::class, 'saveChallengeDetails']);
    Route::post('user/save/financials/{financial}', [ChallengeController::class, 'saveChallengeFinancials']);
    Route::post('user/save/teams/{challenge}', [ChallengeController::class, 'saveChallengeTeams']);
    Route::post('user/like', [ChallengeController::class, 'likeChallenge']);
    Route::post('user/dislike', [ChallengeController::class, 'dislikeChallenge']);
    Route::post('user/follow', [ChallengeController::class, 'followChallenge']);
    Route::post('{challenge_id}/user/unfollow', [ChallengeController::class, 'unfollowChallenge']);
    Route::post('images/store', [ChallengeController::class, 'storeImage']);
    Route::post('publish', [ChallengeController::class, 'publish']);
    Route::post('unpublish', [ChallengeController::class, 'unpublish']);
    Route::post('change/dates', [ChallengeController::class, 'changeDates']);
    Route::post('local-vision/save', [ChallengeController::class, 'localVisionSave']);
    Route::post('local-vision/get', [ChallengeController::class, 'localVisionGet']);
    Route::post('local-vision/delete', [ChallengeController::class, 'localVisionDelete']);
    Route::post('local-vision/accept', [ChallengeController::class, 'localVisionAccept']);
    Route::post('financial-details/save', [ChallengeController::class, 'financialDetailsSave']);
    Route::post('technical-details/save', [ChallengeController::class, 'technicalDetailsSave']);
    Route::post('project-offer/accept', [ChallengeController::class, 'projectOfferAccept']);
    Route::post('details/accept', [ChallengeController::class, 'projectDetailsAccept']);
    Route::post('freesave/save', [ChallengeController::class, 'saveFreeSave']);
});
