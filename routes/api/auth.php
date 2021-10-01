<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('email/verify/{id}/{hash}', [AuthController::class, 'emailVerification'])
    ->middleware(['signed'])
    ->name('verification.verify');
