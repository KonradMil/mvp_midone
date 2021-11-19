<?php

use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\ShowroomController;
use App\Http\Controllers\Admin\ForumController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'web']], function () {
    Route::group(['prefix' => 'projects'], function () {

    });
    Route::group(['prefix' => 'users'], function () {

    });
    Route::group(['prefix' => 'showrooms'], function () {
        Route::get('get', [ShowroomController::class, 'index']);
        Route::post('save', [ShowroomController::class, 'saveShowroom']);
    });
    Route::group(['prefix' => 'forum'], function () {
        Route::post('category/save', [ForumController::class, 'saveCategory']);
        Route::post('discussion/save', [ForumController::class, 'saveDiscussion']);
        Route::post('discussions/stick', [ForumController::class, 'stickUnstick']);
        Route::post('discussions/delete', [ForumController::class, 'deleteDiscussions']);
        Route::get('categories/get', [ForumController::class, 'categoriesIndex']);
        Route::get('discussions/get', [ForumController::class, 'discussionIndex']);
        Route::get('posts/get', [ForumController::class, 'postsIndex']);
        Route::get('categories/top/get', [ForumController::class, 'getTopCategories']);
        Route::get('categories/{id}/children', [ForumController::class, 'getSubCategoriesByParentID']);
        Route::get('saas/get', [ServicesController::class, 'saasIndex']);
        Route::post('saas/save', [ServicesController::class, 'saveSaas']);
    });
});
