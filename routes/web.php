<?php

use App\Http\Controllers\S3Controller;
use Illuminate\Support\Facades\Route;
Route::get('s3/{path}', [S3Controller::class, 'reRoute']) ->where('path', '(.*)');;
Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');

