<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Crud\ChallengeController;
use App\Http\Controllers\Crud\ModelController;
use App\Http\Controllers\Crud\QuestionController;
use App\Http\Controllers\Crud\SolutionController;
use App\Http\Controllers\Crud\TeamsController;
use App\Http\Controllers\Crud\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\KnowledgebaseController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('reset-password', [UserController::class, 'reset']);
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
Route::post('forgot-password', [UserController::class, 'forgotPassword']);
Route::get('reset-password/{token}', [UserController::class, 'resetPassword']);

Route::post('locations', 'App\Http\Controllers\TestController@locations');
Route::post('locations/own', 'App\Http\Controllers\TestController@locationsOwn');
Route::post('locations/sync', 'App\Http\Controllers\TestController@locationSync');
Route::post('locations/get', 'App\Http\Controllers\TestController@getLocations');
Route::get('import', 'App\Http\Controllers\TestController@importModels');

Route::group(['prefix' => 'company', 'middleware' => 'auth:sanctum'], function () {
    Route::post('search/nip', 'App\Http\Controllers\TerytController@searchRegonNip');
    Route::post('search/krs', 'App\Http\Controllers\TerytController@searchRegonKrs');
    Route::post('create', 'App\Http\Controllers\API\CompanyController@saveCompany');
    Route::post('save', 'App\Http\Controllers\API\CompanyController@saveCompanyEdit');
    Route::get('get', '\App\Http\Controllers\API\CompanyController@getUserCompanies');
});

Route::group(['prefix' => 'workshop', 'middleware' => 'auth:sanctum'], function() {
    Route::post('objects/get', [WorkshopController::class, 'getObjects']);
    Route::post('object/like', [WorkshopController::class, 'likeObject']);
});

Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function() {
     Route::post('terms/save', [UserController::class, 'saveTerms']);
});

Route::group(['prefix' => 'question', 'middleware' => 'auth:sanctum'], function() {
   Route::post('create', [QuestionController::class, 'create']);
   Route::post('get', [QuestionController::class, 'get']);
});

Route::post('dashboard/get', [DashboardController::class, 'getDataForDashboard']);

Route::group(['prefix' => 'challenge', 'middleware' => 'auth:sanctum'], function () {
    Route::post('delete', [ChallengeController::class, 'delete']);
    Route::post('user/get', [ChallengeController::class, 'getUserChallengesFiltered']);
    Route::post('check-team', [ChallengeController::class, 'checkTeam']);
    Route::post('user/save/description', [ChallengeController::class, 'saveDescription']);
    Route::post('user/get/followed', [ChallengeController::class, 'getUserChallengesFollowed']);
    Route::post('user/get/card', [ChallengeController::class, 'getCardData']);
    Route::post('user/create', [ChallengeController::class, 'createChallenge']);
    Route::post('user/save', [ChallengeController::class, 'saveChallenge']);
    Route::post('user/save/details/{technical}', [ChallengeController::class, 'saveChallengeDetails']);
    Route::post('user/save/financials/{financial}', [ChallengeController::class, 'saveChallengeFinancials']);
    Route::post('user/save/teams/{challenge}', [ChallengeController::class, 'saveChallengeTeams']);
    Route::post('user/like', [ChallengeController::class, 'likeChallenge']);
    Route::post('user/dislike', [ChallengeController::class, 'dislikeChallenge']);
    Route::post('user/follow', [ChallengeController::class, 'followChallenge']);
    Route::post('user/unfollow', [ChallengeController::class, 'unfollowChallenge']);
    Route::post('user/comment', [ChallengeController::class, 'commentChallenge']);
    Route::post('images/store', [ChallengeController::class, 'storeImage']);
    Route::post('publish', [ChallengeController::class, 'publish']);
    Route::post('unpublish', [ChallengeController::class, 'unpublish']);
});

//Route::group(['prefix' => 'solution', 'middleware' => 'auth:sanctum'], function () {
//    Route::post('create', [SolutionController::class, 'create']);
//});

Route::post('report/show', [ReportController::class, 'getReport']);
Route::post('search', [SearchController::class, 'search']);

Route::group(['prefix' => 'offer', 'middleware' => 'auth:sanctum'], function () {
    Route::post('get', [OfferController::class, 'get']);
    Route::post('save', [OfferController::class, 'save']);
    Route::post('get/all', [OfferController::class, 'getAll']);
    Route::post('get/challenge/offers/{challenge}', [OfferController::class, 'getAllChallengeOffers']);
});

Route::group(['prefix' => 'report', 'middleware' => 'auth:sanctum'], function () {
    Route::post('user/get', [ReportController::class, 'getUserReports']);
    Route::post('user/show', [ReportController::class, 'getReport']);
    Route::post('user/create', [ReportController::class, 'createReport']);
    Route::post('user/delete', [ReportController::class, 'deleteReport']);
    Route::post('files/store', [ReportController::class, 'storeFile']);
});

Route::group(['prefix' => 'solution', 'middleware' => 'auth:sanctum'], function () {
    Route::post('accept', [SolutionController::class, 'acceptSolution']);
    Route::post('reject', [SolutionController::class, 'rejectSolution']);
    Route::post('user/get', [SolutionController::class, 'getUserSolutionsFiltered']);
    Route::post('save/description', [SolutionController::class, 'saveDescription']);
    Route::post('check-team', [SolutionController::class, 'checkTeam']);
    Route::post('get/unity', [SolutionController::class, 'getUserSolutionUnity']);
    Route::post('user/create', [SolutionController::class, 'createSolution']);
    Route::post('create', [SolutionController::class, 'create']);
    Route::post('save/financials/{financial}', [SolutionController::class, 'saveSolutionFinancials']);
    Route::post('user/save/teams/{solution}', [SolutionController::class, 'saveSolutionTeams']);
    Route::post('save', [SolutionController::class, 'saveSolution']);
    Route::post('user/like', [SolutionController::class, 'likeSolution']);
    Route::post('user/comment', [SolutionController::class, 'commentSolution']);
    Route::post('images/store', [SolutionController::class, 'storeImage']);
    Route::post('publish', [SolutionController::class, 'publish']);
    Route::post('unpublish', [SolutionController::class, 'unpublish']);
    Route::post('delete', [SolutionController::class, 'delete']);
});

Route::group(['prefix' => 'knowledgebase/post', 'middleware' => 'auth:sanctum'], function () {
    Route::post('get', [KnowledgebaseController::class, 'getPosts']);
    Route::post('add', [KnowledgebaseController::class, 'addPost']);
    Route::post('edit', [KnowledgebaseController::class, 'editPost']);
    Route::post('like', [KnowledgebaseController::class, 'likePost']);
});

Route::post('user/comment', [CommentsController::class, 'comment']);
Route::post('user/comment/delete', [CommentsController::class, 'commentDelete']);

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
    Route::post('user/delete', [TeamsController::class, 'deleteTeam']);
    Route::post('user/member/delete', [TeamsController::class, 'deleteMember']);
    Route::post('user/add/team', [TeamsController::class, 'addObjectTeam']);
});

Route::post('model/edit/{model}', [ModelController::class, 'editModel']);
Route::post('model/get', [ModelController::class, 'getModel']);
Route::post('model/delete', [ModelController::class, 'deleteModel']);

Route::group(['prefix' => 'models', 'middleware' => 'auth:sanctum'], function () {
    Route::post('get', [ModelController::class, 'getModels']);
    Route::post('get/unity', [ModelController::class, 'getModelsUnity']);
    Route::post('add', [ModelController::class, 'addModel']);
});

Route::group(['prefix' => 'workshop/models', 'middleware' => 'auth:sanctum'], function () {
    Route::post('get/all', [WorkshopController::class, 'getWorkshopModels']);
    Route::post('get', [WorkshopController::class, 'getWorkshopModel']);
    Route::post('save', [WorkshopController::class, 'saveWorkshopModel']);
});

Route::group(['prefix' => 'offer', 'middleware' => 'auth:sanctum'], function () {
    Route::post('add/new', [OfferController::class, 'addOffer']);
});


