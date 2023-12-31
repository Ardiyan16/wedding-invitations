<?php

use Illuminate\Support\Facades\Route;
//controller
use App\Http\Controllers\AdminController;

//middleware
use App\Http\Middleware\IsGuest;
use App\Http\Middleware\IsAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(IsGuest::class)->group(function(){
    Route::get('/', [AdminController::class, 'login'])->name('login');
});

Route::middleware(IsAdmin::class)->group(function(){
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::prefix('admin-wedding')->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/template-undangan', [AdminController::class, 'template'])->name('template');
        Route::get('/data-pengantin', [AdminController::class, 'pengantin'])->name('pengantin');
    });

});
