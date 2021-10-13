<?php

use App\Http\Controllers\FreeSavesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'playground', 'middleware' => 'auth:sanctum'], function () {
    Route::get('saves', [FreeSavesController::class, 'getSaves']);
    Route::post('saves/delete', [FreeSavesController::class, 'deleteSave']);
});
