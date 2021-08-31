<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\S3Controller;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::post('set/txt', [S3Controller::class, 'txtFile']);
Route::post('dashboard/get', [DashboardController::class, 'getDataForDashboard']);
Route::post('search', [SearchController::class, 'search']);
Route::post('/broadcast/auth', [NotificationsController::class, 'broadcastAuth']);

require __DIR__ . '/api/solutions.php';
require __DIR__ . '/api/reports.php';
require __DIR__ . '/api/knowledgebase.php';
require __DIR__ . '/api/security.php'; //@TODO zorganizować tutaj logowanie, rejestrację itp. pod AuthController
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
