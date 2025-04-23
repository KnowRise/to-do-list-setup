<?php

use App\Http\Controllers\Backend\JobController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\AuthController as FrontendAuthController;
use App\Http\Controllers\Backend\AuthController as BackendAuthController;
use App\Http\Controllers\Frontend\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('auth')->group(function () {
    Route::get('/login', [FrontendAuthController::class, 'login'])->name('login');
    Route::group(['prefix' => 'backend', 'controller' => BackendAuthController::class], function () {
        Route::post('/login', 'login')->name('backend.login');
        Route::post('/logout', 'logout')->name('backend.logout');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::prefix('users')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::post('/{id?}', 'storeUser')->name('backend.users.store');
            Route::delete('/{id}', 'deleteUser')->name('backend.users.delete');
        });
    });
    Route::prefix('jobs')->group(function () {
        Route::controller(JobController::class)->group(function () {
            Route::post('/{id?}', 'storeJob')->name('backend.jobs.store');
        });
    });
});
