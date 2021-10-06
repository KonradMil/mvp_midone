<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
    Route::post('terms/save', [UserController::class, 'saveTerms']);
    Route::post('register-authy', [UserController::class, 'registerAuthy']);
});

Route::get('testme', [UserController::class, 'test']);
Route::post('check/twofa', [UserController::class, 'checkTwoFa']);
Route::post('reset-password', [UserController::class, 'reset']);
Route::post('logout', [UserController::class, 'logout']);
Route::get('logout', [UserController::class, 'logout']);
Route::get('email/unique/{email}', [UserController::class, 'checkEmail']);

Route::post('avatar/store', [UserController::class, 'storeAvatar']);
Route::post('profile/update', [UserController::class, 'updateProfile']);
Route::post('profile/change-password', [UserController::class, 'changePassword']);
Route::get('communication', [UserController::class, 'getUsers']);
Route::post('forgot-password', [UserController::class, 'forgotPassword']);
//Route::get('reset-password/{token}', [UserController::class, 'resetPassword']);
