<?php
use Illuminate\Support\Facades\Route;

Route::prefix('challenges/questions')->middleware('auth:sanctum')->group(base_path('routes/api/challenges/questions.php'));
Route::prefix('challenges/comments')->middleware('auth:sanctum')->group(base_path('routes/api/challenges/comments.php'));


Route::group(['prefix' => 'challenges', 'middleware' => 'auth:sanctum'], function () {

});
