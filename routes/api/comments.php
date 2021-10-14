<?php

use App\Http\Controllers\CommentsController;
use Illuminate\Support\Facades\Route;

Route::post('user/comment', [CommentsController::class, 'comment']);
Route::post('user/comment/delete', [CommentsController::class, 'commentDelete']);
