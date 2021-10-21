<?php

use App\Http\Controllers\S3Controller;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('site', function () {
    return view('site.layouts.app');
});

Route::get('projekty-ue', function () {
    return view('ue-project');
});
Route::get('impersonate', [UserController::class, 'impersonate'])->middleware('web');
Route::get('s3/{path}', [S3Controller::class, 'reRoute'])->where('path', '(.*)');
Route::get('models/{path}', [S3Controller::class, 'reRoutes'])->where('path', '(.*)');
Route::get('studio/s3/{path}', [S3Controller::class, 'reRoute'])->where('path', '(.*)');

Route::get('studio/challenge/{challengeId}', [StudioController::class, 'challenge']);

require 'web/auth.php';
require 'web/teams.php';

Route::get('/test', function(){


    $mailer = Mail::getSwiftMailer();

    $logger = new \Swift_Plugins_Loggers_ArrayLogger();

    $mailer->registerPlugin(new \Swift_Plugins_LoggerPlugin($logger));

    Mail::to('robugpl@gmail.com')->send(new \App\Mail\RoboHakatonMail());

    dd($logger);



});

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');


