<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v2\UserController;

Route::group(['prefix' => 'v2/user', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/company/is_valid', [UserController::class, 'getCompanyData']);
});
