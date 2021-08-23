<?php

use App\Http\Controllers\KnowledgebaseController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'knowledgebase/post', 'middleware' => 'auth:sanctum'], function () {
    Route::post('get', [KnowledgebaseController::class, 'getPosts']);
    Route::post('add', [KnowledgebaseController::class, 'addPost']);
    Route::post('edit', [KnowledgebaseController::class, 'editPost']);
    Route::post('like', [KnowledgebaseController::class, 'likePost']);
});
