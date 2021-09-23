<?php

use App\Http\Controllers\S3Controller;
use App\Http\Controllers\StudioController;
use Illuminate\Support\Facades\Route;

Route::get('site', function () {
    return view('site.layouts.app');
});

Route::get('projekty-ue', function () {
    return view('ue-project');
});

Route::get('s3/{path}', [S3Controller::class, 'reRoute'])->where('path', '(.*)');
Route::get('models/{path}', [S3Controller::class, 'reRoutes'])->where('path', '(.*)');
Route::get('studio/s3/{path}', [S3Controller::class, 'reRoute'])->where('path', '(.*)');

Route::get('studio/challenge/{challengeId}', [StudioController::class, 'challenge']);

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');


