<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Crud\ChallengeController;
use App\Http\Controllers\Crud\ModelController;
use App\Http\Controllers\Crud\SolutionController;
use App\Http\Controllers\Crud\TeamsController;
use App\Http\Controllers\Crud\ReportController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\KnowledgebaseController;
use App\Http\Controllers\CommentsController;
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
Route::post('profile/change-password', 'App\Http\Controllers\API\UserController@changePassword');
Route::get('communication', 'App\Http\Controllers\API\UserController@getUsers');

Route::post('locations', 'App\Http\Controllers\TestController@locations');
Route::post('locations/own', 'App\Http\Controllers\TestController@locationsOwn');
Route::post('locations/sync', 'App\Http\Controllers\TestController@locationSync');
Route::post('locations/get', 'App\Http\Controllers\TestController@getLocations');
Route::get('import', 'App\Http\Controllers\TestController@importModels');

Route::group(['prefix' => 'company', 'middleware' => 'auth:sanctum'], function () {
    Route::post('search/nip', 'App\Http\Controllers\TerytController@searchRegonNip');
    Route::post('search/krs', 'App\Http\Controllers\TerytController@searchRegonKrs');
    Route::post('create', 'App\Http\Controllers\API\CompanyController@saveCompany');
});

Route::group(['prefix' => 'challenge', 'middleware' => 'auth:sanctum'], function () {
    Route::post('user/get', [ChallengeController::class, 'getUserChallengesFiltered']);
    Route::post('user/get/card', [ChallengeController::class, 'getCardData']);
    Route::post('user/create', [ChallengeController::class, 'createChallenge']);
    Route::post('user/like', [ChallengeController::class, 'likeChallenge']);
    Route::post('user/comment', [ChallengeController::class, 'commentChallenge']);
    Route::post('images/store', [ChallengeController::class, 'storeImage']);
});


Route::post('report/show', [ReportController::class, 'getReport']);

Route::group(['prefix' => 'report', 'middleware' => 'auth:sanctum'], function () {
    Route::post('user/get', [ReportController::class, 'getUserReports']);
    Route::post('user/show', [ReportController::class, 'getReport']);
    Route::post('user/create', [ReportController::class, 'createReport']);
    Route::post('user/delete', [ReportController::class, 'deleteReport']);
    Route::post('files/store', [ReportController::class, 'storeFile']);
});

Route::group(['prefix' => 'solution', 'middleware' => 'auth:sanctum'], function () {
    Route::post('user/get', [SolutionController::class, 'getUserSolutionsFiltered']);
    Route::post('user/create', [SolutionController::class, 'createSolution']);
    Route::post('user/like', [SolutionController::class, 'likeSolution']);
    Route::post('user/comment', [SolutionController::class, 'commentSolution']);
    Route::post('images/store', [SolutionController::class, 'storeImage']);
});


Route::group(['prefix' => 'knowledgebase/post', 'middleware' => 'auth:sanctum'], function () {
    Route::post('get', [KnowledgebaseController::class, 'getPosts']);
    Route::post('add', [KnowledgebaseController::class, 'addPost']);
    Route::post('edit', [KnowledgebaseController::class, 'editPost']);
    Route::post('like', [KnowledgebaseController::class, 'likePost']);
});

Route::post('user/comment', [CommentsController::class, 'comment']);

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

Route::post('model/edit/{model}', [ModelController::class, 'editModel']);
Route::post('model/get', [ModelController::class, 'getModel']);
Route::post('model/delete', [ModelController::class, 'deleteModel']);
Route::group(['prefix' => 'models', 'middleware' => 'auth:sanctum'], function () {
    Route::post('get', [ModelController::class, 'getModels']);
    Route::post('add', [ModelController::class, 'addModel']);
});
