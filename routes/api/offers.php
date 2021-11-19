<?php

use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'offer', 'middleware' => 'auth:sanctum'], function () {
    Route::post('user/check', [OfferController::class, 'check']);
    Route::post('get/best', [OfferController::class, 'theBestChallengeOffer']);
    Route::post('get', [OfferController::class, 'get']);
    Route::post('user/filter', [OfferController::class, 'filterChallengeOffers']);
    Route::post('{challenge_id}/delete', [OfferController::class, 'delete']);
    Route::post('solution/save', [OfferController::class, 'saveSolutionOffer']);
    Route::post('project/save', [OfferController::class, 'saveProjectOffer']);
    Route::get('{challenge_id}/all', [OfferController::class, 'getAll']);
    Route::post('{challenge_id}/publish', [OfferController::class, 'publishOffer']);
    Route::get('{challenge_id}/offers', [OfferController::class, 'getAllChallengeOffers']);
    Route::post('add/new', [OfferController::class, 'addOffer']);
    Route::post('{challenge_id}/accept', [OfferController::class, 'acceptOffer']);
    Route::post('{challenge_id}/reject', [OfferController::class, 'rejectOffer']);
});
