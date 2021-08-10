<?php
use Illuminate\Support\Facades\Route;

Route::prefix('solutions/comments')->middleware('auth:sanctum')->group(base_path('routes/api/knowledgebase/comments.php'));
Route::prefix('solutions/offers')->middleware('auth:sanctum')->group(base_path('routes/api/knowledgebase/offers.php'));
Route::prefix('solutions/reports')->middleware('auth:sanctum')->group(base_path('routes/api/knowledgebase/reports.php'));

Route::group(['prefix' => 'solutions', 'middleware' => 'auth:sanctum'], function () {

});
