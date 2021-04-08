<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Crud\ChallengeController;
use App\Http\Controllers\Crud\TeamsController;
use App\Http\Controllers\NotificationsController;
use Illuminate\Http\Request;
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

Route::group(['prefix' => 'challenge', 'middleware' => 'auth:sanctum'], function () {
    Route::post('user/get', [ChallengeController::class, 'getUserChallengesFiltered']);
    Route::post('user/create', [ChallengeController::class, 'createChallenge']);
    Route::post('user/like', [ChallengeController::class, 'likeChallenge']);
    Route::post('user/comment', [ChallengeController::class, 'commentChallenge']);
    Route::post('images/store', [ChallengeController::class, 'storeImage']);
});

Route::group(['prefix' => 'knowledgebase/post', 'middleware' => 'auth:sanctum'], function () {
    Route::post('get', [ChallengeController::class, 'getPosts']);
    Route::post('add', [ChallengeController::class, 'addPost']);
    Route::post('edit', [ChallengeController::class, 'editPost']);
});

Route::group(['prefix' => 'notifications', 'middleware' => 'auth:sanctum'], function () {
    Route::post('get', [NotificationsController::class, 'getNotifications']);
});
Route::post('/broadcast/auth',  [NotificationsController::class, 'broadcastAuth']);

Route::group(['prefix' => 'teams', 'middleware' => 'auth:sanctum'], function () {
    Route::post('user/create', [TeamsController::class, 'createTeam']);
    Route::post('user/add', [TeamsController::class, 'addUserToTeam']);
    Route::post('user/invite', [TeamsController::class, 'inviteUser']);
    Route::post('user/invites/get', [TeamsController::class, 'getUserInvites']);
    Route::post('user/invite/accept', [TeamsController::class, 'acceptInvite']);
    Route::post('user/get', [TeamsController::class, 'getUserTeamsFiltered']);
});

