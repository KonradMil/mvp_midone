<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'files', 'middleware' => 'auth:sanctum'], function () {
    Route::post('{challenge_id}/solution/{solution_id}/store', [FileController::class, 'saveSolutionFiles']);
});
