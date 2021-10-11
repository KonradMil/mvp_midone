<?php

use App\Http\Controllers\Web\TeamsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'teams', 'middleware' => ['web']], function () {
    Route::get('claim_invitation', [TeamsController::class, 'claimInvitation'])->name('teams_claim_invitation');
});
