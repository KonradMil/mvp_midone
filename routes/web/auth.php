<?php

use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/social/{provider}/sign_in', [AuthController::class, 'socialSignIn']);
Route::get('/auth/social/{provider}/sign_up', [AuthController::class, 'socialSignUp']);
Route::get('/auth/social/{provider}/callback', [AuthController::class, 'socialCallback']);

