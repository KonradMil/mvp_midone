<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TerytController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'company', 'middleware' => 'auth:sanctum'], function () {
    Route::post('search/nip', [TerytController::class, 'searchRegonNip']);
    Route::post('search/krs', [TerytController::class, 'searchRegonKrs']);
    Route::post('create', [CompanyController::class, 'saveCompany']);
    Route::post('save', [CompanyController::class, 'saveCompany']);
    Route::get('get', [CompanyController::class, 'getUserCompanies']);
});
