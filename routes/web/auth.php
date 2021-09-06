<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('email/verify/{id}/{hash}', [AuthController::class, 'emailVerification'])
    ->middleware(['signed'])
    ->name('verification.verify');

Route::get('login', function(){
    return view('app');
})->name('login');
