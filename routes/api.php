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

    Route::post('search', [SearchController::class, 'search']);
    Route::post('/broadcast/auth', [NotificationsController::class, 'broadcastAuth']);


    require __DIR__ . '/api/files.php';
    require __DIR__ . '/api/reports.php';
    require __DIR__ . '/api/auth.php'; //@TODO zorganizować tutaj logowanie, rejestrację itp. pod AuthController
    require __DIR__ . '/api/users.php';
    require __DIR__ . '/api/companies.php';
    require __DIR__ . '/api/comments.php';
    require __DIR__ . '/api/notifications.php';
    require __DIR__ . '/api/teams.php';

    require __DIR__ . '/api/v2/user.php';
    require __DIR__ . '/api/v2/studio.php';

});
