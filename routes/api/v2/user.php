<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v2\UserController;

Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/company', [UserController::class, 'getCompanyData']);
});
