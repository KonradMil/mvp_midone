<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::post('save/file', [FileController::class, 'saveAnyFile']);
Route::group(['prefix' => 'files', 'middleware' => 'auth:sanctum'], function () {
    Route::post('{challenge_id}/solution/{solution_id}/store', [FileController::class, 'saveSolutionFiles']);
});
