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
use App\Http\Controllers\OldImportController;
use App\Http\Controllers\S3Controller;
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
     Route::post('register-authy', [UserController::class, 'registerAuthy']);
});

Route::group(['prefix' => 'question', 'middleware' => 'auth:sanctum'], function() {
   Route::post('create', [QuestionController::class, 'create']);
   Route::post('get', [QuestionController::class, 'get']);
});

Route::post('set/txt', [S3Controller::class, 'txtFile']);
Route::post('testme', [UserController::class, 'test']);
Route::post('check/twofa', [UserController::class, 'checkTwoFa']);

Route::post('dashboard/get', [DashboardController::class, 'getDataForDashboard']);

Route::group(['prefix' => 'challenge', 'middleware' => 'auth:sanctum'], function () {
    Route::post('delete', [ChallengeController::class, 'delete']);
    Route::post('user/get', [ChallengeController::class, 'getUserChallengesFiltered']);
    Route::post('user/get/projects', [ChallengeController::class, 'getUserChallengesProjects']);
    Route::post('check-team', [ChallengeController::class, 'checkTeam']);
    Route::post('user/save/description', [ChallengeController::class, 'saveDescription']);
    Route::post('user/get/followed', [ChallengeController::class, 'getUserChallengesFollowed']);
    Route::post('user/get/archive', [ChallengeController::class, 'getUserChallengesArchive']);
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
    Route::post('change/dates', [ChallengeController::class, 'changeDates']);
});

//Route::group(['prefix' => 'solution', 'middleware' => 'auth:sanctum'], function () {
//    Route::post('create', [SolutionController::class, 'create']);
//});

Route::post('report/show', [ReportController::class, 'getReport']);
Route::post('search', [SearchController::class, 'search']);

Route::group(['prefix' => 'offer', 'middleware' => 'auth:sanctum'], function () {
    Route::post('user/check', [OfferController::class, 'check']);
    Route::post('get/best', [OfferController::class, 'theBestChallengeOffer']);
    Route::post('get', [OfferController::class, 'get']);
    Route::post('user/filter', [OfferController::class, 'filterChallengeOffers']);
    Route::post('delete', [OfferController::class, 'delete']);
    Route::post('save', [OfferController::class, 'save']);
    Route::post('get/all', [OfferController::class, 'getAll']);
    Route::post('publish', [OfferController::class, 'publishOffer']);
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
    Route::post('robots', [SolutionController::class, 'getRobots']);
    Route::post('save/robot', [SolutionController::class, 'saveRobot']);
    Route::post('filter', [SolutionController::class, 'deleteSolutionsNull']);
    Route::post('user/filter', [SolutionController::class, 'filterChallengeSolutions']);
    Route::post('user/get/archive', [SolutionController::class, 'getUserSolutionsArchive']);
    Route::post('accept', [SolutionController::class, 'acceptSolution']);
    Route::post('reject', [SolutionController::class, 'rejectSolution']);
    Route::post('user/get', [SolutionController::class, 'getUserSolutionsFiltered']);
    Route::post('save/description', [SolutionController::class, 'saveDescription']);
    Route::post('check-team', [SolutionController::class, 'checkTeam']);
    Route::post('filter-member', [SolutionController::class, 'filterMember']);
    Route::post('get/unity', [SolutionController::class, 'getUserSolutionUnity']);
    Route::post('user/create', [SolutionController::class, 'createSolution']);
    Route::post('create', [SolutionController::class, 'create']);
    Route::post('save/financials/{financial}', [SolutionController::class, 'saveSolutionFinancials']);
    Route::post('user/save/teams/{solution}', [SolutionController::class, 'saveSolutionTeams']);
    Route::post('user/get/solutions/challenge/{challenge}', [SolutionController::class, 'getUserSolutionsChallenge']);
    Route::post('user/get/solutions/project', [SolutionController::class, 'getUserSolutionsProject']);
    Route::post('save', [SolutionController::class, 'saveSolution']);
    Route::post('user/like', [SolutionController::class, 'likeSolution']);
    Route::post('user/dislike', [SolutionController::class, 'dislikeSolution']);
    Route::post('user/comment', [SolutionController::class, 'commentSolution']);
    Route::post('images/store', [SolutionController::class, 'storeImage']);
    Route::post('publish', [SolutionController::class, 'publish']);
    Route::post('unpublish', [SolutionController::class, 'unpublish']);
    Route::post('delete', [SolutionController::class, 'delete']);
    Route::post('estimate/save', [SolutionController::class, 'estimateSave']);
    Route::post('financial-analyses/save', [SolutionController::class, 'financialAnalysesSave']);
    Route::post('operational-analyses/save', [SolutionController::class, 'operationalAnalysesSave']);
    Route::post('estimate/get', [SolutionController::class, 'estimateGet']);
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
    Route::post('remove-from-selected', [TeamsController::class, 'removeFromSelected']);
    Route::post('add-to-selected', [TeamsController::class, 'addToSelected']);
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
    Route::post('delete', [WorkshopController::class, 'delete']);
    Route::post('publish', [WorkshopController::class, 'publish']);
    Route::post('like', [WorkshopController::class, 'likeObject']);
    Route::post('copy', [WorkshopController::class, 'copy']);
});

Route::group(['prefix' => 'offer', 'middleware' => 'auth:sanctum'], function () {
    Route::post('add/new', [OfferController::class, 'addOffer']);
    Route::post('accept', [OfferController::class, 'acceptOffer']);
    Route::post('reject', [OfferController::class, 'rejectOffer']);
});

Route::get('import-old', [OldImportController::class, 'import']);
Route::get('test123', function () {
   $oldUser = \App\Models\OldUser::get();
    foreach ($oldUser as $item) {
        dump($item->teams);
   }
//   $oldTeam = \App\Models\OldTeam::get();
//   dd([$oldTeam, $oldUser]);
});

