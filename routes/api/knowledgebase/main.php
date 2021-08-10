<?php
use Illuminate\Support\Facades\Route;

Route::prefix('knowledgebase/posts')->middleware('auth:sanctum')->group(base_path('routes/api/knowledgebase/posts.php'));

Route::group(['prefix' => 'knowledgebase', 'middleware' => 'auth:sanctum'], function () {

});
