<?php

use App\Http\Controllers\TestAuthorizationController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'test_auth', 'middleware' => 'auth:sanctum'], function(){
    Route::get('search', [TestAuthorizationController::class, 'searchAction']);
    Route::get('get', [TestAuthorizationController::class, 'getAction']);
    Route::post('update', [TestAuthorizationController::class, 'updateAction']);
    Route::post('delete', [TestAuthorizationController::class, 'deleteAction']);
});
