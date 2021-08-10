<?php
use Illuminate\Support\Facades\Route;

Route::prefix('social/posts')->middleware('auth:sanctum')->group(base_path('routes/api/social/posts.php'));
Route::prefix('social/threads')->middleware('auth:sanctum')->group(base_path('routes/api/social/threads.php'));

Route::group(['prefix' => 'social', 'middleware' => 'auth:sanctum'], function () {

});
