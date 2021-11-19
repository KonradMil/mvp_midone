<?php

use App\Http\Controllers\Admin\ShowroomController;
use Illuminate\Support\Facades\Route;

Route::post('showroom/login/{organization}', [ShowroomController::class, 'loginVisitor']);
