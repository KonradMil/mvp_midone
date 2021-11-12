<?php

use App\Http\Controllers\RobochallengeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\S3Controller;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

App::setLocale('pl');

Route::group(['middleware' => 'web'], function () {

    Route::post('save/screenshot', [S3Controller::class, 'save8KScreenshot']);
    Route::post('set/txt', [S3Controller::class, 'txtFile']);
    Route::post('dashboard/get', [DashboardController::class, 'getDataForDashboard'])->middleware();
    Route::post('search', [SearchController::class, 'search']);
    Route::post('/broadcast/auth', [NotificationsController::class, 'broadcastAuth']);

    Route::post('/robochallenge', [RobochallengeController::class, 'register']);

    require __DIR__ . '/api/v2/showroom.php';
    require __DIR__ . '/api/studio-lite.php';
    require __DIR__ . '/api/files.php';
    require __DIR__ . '/api/admin.php';
    require __DIR__ . '/api/solutions.php';
    require __DIR__ . '/api/reports.php';
    require __DIR__ . '/api/knowledgebase.php';
    require __DIR__ . '/api/auth.php'; //@TODO zorganizować tutaj logowanie, rejestrację itp. pod AuthController
    require __DIR__ . '/api/users.php';
    require __DIR__ . '/api/companies.php';
    require __DIR__ . '/api/workshop.php';
    require __DIR__ . '/api/challenges.php';
    require __DIR__ . '/api/questions.php';
    require __DIR__ . '/api/comments.php';
    require __DIR__ . '/api/notifications.php';
    require __DIR__ . '/api/teams.php';
    require __DIR__ . '/api/models.php';
    require __DIR__ . '/api/workshop_models.php';
    require __DIR__ . '/api/offers.php';
    require __DIR__ . '/api/projects.php';
    require __DIR__ . '/api/freesaves.php';

    require __DIR__ . '/api/v2/user.php';
    require __DIR__ . '/api/v2/studio.php';

});
