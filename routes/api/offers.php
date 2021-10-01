<?php

use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'offer', 'middleware' => 'auth:sanctum'], function () {
    Route::post('user/check', [OfferController::class, 'check']);
    Route::post('get/best', [OfferController::class, 'theBestChallengeOffer']);
    Route::post('get', [OfferController::class, 'get']);
    Route::post('user/filter', [OfferController::class, 'filterChallengeOffers']);
    Route::post('delete', [OfferController::class, 'delete']);
    Route::post('save', [OfferController::class, 'save']);
    Route::post('get/all', [OfferController::class, 'getAll']);
    Route::post('publish', [OfferController::class, 'publishOffer']);
    Route::post('get/challenge/offers/{challenge}', [OfferController::class, 'getAllChallengeOffers']);
    Route::post('add/new', [OfferController::class, 'addOffer']);
    Route::post('accept', [OfferController::class, 'acceptOffer']);
    Route::post('reject', [OfferController::class, 'rejectOffer']);
});
