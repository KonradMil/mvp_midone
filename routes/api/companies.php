<?php

use App\Http\Controllers\TerytController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'company', 'middleware' => 'auth:sanctum'], function () {
    Route::post('search/nip', [TerytController::class, 'searchRegonNip']);
    Route::post('search/krs', [TerytController::class, 'searchRegonKrs']);
    Route::post('create', [TerytController::class, 'saveCompany']);
    Route::post('save', [TerytController::class, 'saveCompanyEdit']);
    Route::get('get', [TerytController::class, 'getUserCompanies']);
});
