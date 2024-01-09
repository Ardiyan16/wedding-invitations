<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//controller
use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\API\ApiTemplateController;
use App\Http\Controllers\API\ApiBankController;
use App\Http\Controllers\API\ApiPengantinController;

//middleware
use App\Http\Middleware\IsApi;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [ApiAuthController::class, 'login']);

Route::prefix('v1')->middleware(IsApi::class)->group(function() {

    Route::prefix('template')->group(function() {
        Route::post('/data', [ApiTemplateController::class, 'index']);
        Route::post('/simpan', [ApiTemplateController::class, 'store']);
        Route::post('/update', [ApiTemplateController::class, 'update']);
        Route::get('/hapus/{id}', [ApiTemplateController::class, 'destroy']);
    });

    Route::prefix('bank')->group(function() {
        Route::post('/data', [ApiBankController::class, 'index']);
        Route::post('/simpan', [ApiBankController::class, 'store']);
        Route::post('/update', [ApiBankController::class, 'update']);
        Route::get('/hapus/{id}', [ApiBankController::class, 'destroy']);
    });

    Route::prefix('pengantin')->group(function() {
        Route::post('/data', [ApiPengantinController::class, 'index']);
    });

});
