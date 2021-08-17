<?php

use App\Http\Controllers\Crud\ChallengeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'challenge', 'middleware' => 'auth:sanctum'], function () {
    Route::post('delete', [ChallengeController::class, 'delete']);
    Route::post('user/get', [ChallengeController::class, 'getUserChallengesFiltered']);
    Route::post('user/get/projects', [ChallengeController::class, 'getUserChallengesProjects']);
    Route::post('user/get/good/projects', [ChallengeController::class, 'getUserChallengesGoodProjects']);
    Route::post('check-team', [ChallengeController::class, 'checkTeam']);
    Route::post('user/save/description', [ChallengeController::class, 'saveDescription']);
    Route::post('user/get/followed', [ChallengeController::class, 'getUserChallengesFollowed']);
    Route::post('user/get/archive', [ChallengeController::class, 'getUserChallengesArchive']);
    Route::post('user/get/card', [ChallengeController::class, 'getCardData']);
    Route::post('user/create', [ChallengeController::class, 'createChallenge']);
    Route::post('user/save', [ChallengeController::class, 'saveChallenge']);
    Route::post('user/save/details/{technical}', [ChallengeController::class, 'saveChallengeDetails']);
    Route::post('user/save/financials/{financial}', [ChallengeController::class, 'saveChallengeFinancials']);
    Route::post('user/save/teams/{challenge}', [ChallengeController::class, 'saveChallengeTeams']);
    Route::post('user/like', [ChallengeController::class, 'likeChallenge']);
    Route::post('user/dislike', [ChallengeController::class, 'dislikeChallenge']);
    Route::post('user/follow', [ChallengeController::class, 'followChallenge']);
    Route::post('user/unfollow', [ChallengeController::class, 'unfollowChallenge']);
    Route::post('images/store', [ChallengeController::class, 'storeImage']);
    Route::post('publish', [ChallengeController::class, 'publish']);
    Route::post('unpublish', [ChallengeController::class, 'unpublish']);
    Route::post('change/dates', [ChallengeController::class, 'changeDates']);
});
