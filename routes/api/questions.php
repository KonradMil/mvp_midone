<?php

use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'question', 'middleware' => 'auth:sanctum'], function () {
    Route::post('create', [QuestionController::class, 'create']);
    Route::post('get', [QuestionController::class, 'get']);
});
