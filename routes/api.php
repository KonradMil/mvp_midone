<?php

use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::get('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::get('test', function (){dd(\Illuminate\Support\Facades\Auth::user());});
Route::get('email/unique/{email}', 'App\Http\Controllers\API\UserController@checkEmail');
Route::post('avatar/store', 'App\Http\Controllers\API\UserController@storeAvatar');
Route::post('profile/update', 'App\Http\Controllers\API\UserController@updateProfile');

Route::post('locations', 'App\Http\Controllers\TestController@locations');
Route::post('locations/own', 'App\Http\Controllers\TestController@locationsOwn');
Route::post('locations/sync', 'App\Http\Controllers\TestController@locationSync');
Route::post('locations/get', 'App\Http\Controllers\TestController@getLocations');

Route::group(['prefix' => 'company', 'middleware' => 'auth:sanctum'], function () {
    Route::post('search/nip', 'App\Http\Controllers\TerytController@searchRegonNip');
    Route::post('search/krs', 'App\Http\Controllers\TerytController@searchRegonKrs');
    Route::post('create', 'App\Http\Controllers\API\CompanyController@saveCompany');
});

