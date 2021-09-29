<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('login/{provider}', [AuthController::class, 'socialSignIn']);
Route::get('auth/{provider}/callback', 'OutController@index')->where('provider', '.*');

Route::get('email/verify/{id}/{hash}', [AuthController::class, 'emailVerification'])
    ->middleware(['signed'])
    ->name('verification.verify');

Route::post('email/verify/resend_email', [AuthController::class, 'resendVerificationEmail'])
    ->name('verification.resend_email');
