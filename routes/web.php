<?php

use App\Http\Controllers\Backend\JobController as BackendJobController;
use App\Http\Controllers\Backend\TaskController as BackendTaskController;
use App\Http\Controllers\Frontend\TaskController as FrontendTaskController;
use App\Http\Controllers\Frontend\JobController as FrontendJobController;
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
        Route::group(['prefix' => 'backend', 'controller' => UserController::class], function () {
            Route::post('/{id?}', 'storeUser')->name('backend.users.store');
            Route::delete('/{id}', 'deleteUser')->name('backend.users.delete');
        });
    });
    Route::prefix('jobs')->group(function () {
        Route::controller(FrontendJobController::class)->group(function () {
            Route::get('/{id}', 'detail')->name('jobs.detail');
            Route::get('/store/{id}', 'modalStoreJob')->name('jobs.storeJob');
            Route::get('/task/{id}', 'modalNewTask')->name('jobs.newTask');
        });
        Route::group(['prefix' => 'backend', 'controller' => BackendJobController::class], function () {
            Route::post('/{id?}', 'storeJob')->name('backend.jobs.store');
            Route::delete('/{id}', 'deleteJob')->name('backend.jobs.delete');
        });
        Route::prefix('tasks')->group(function () {
            Route::controller(FrontendTaskController::class)->group(function () {
                Route::get('/{id}', 'detail')->name('tasks.detail');
                Route::get('/store/{id}', 'modalStoreTask')->name('tasks.storeTask');
                Route::prefix('users')->group(function () {
                    Route::get('/{id}', 'modalNewUser')->name('tasks.newUser');
                    Route::get('/detail/{id}', 'modalDetailUserTask')->name('tasks.detailUserTask');
                    Route::get('/choose/{id}', 'modalAnotherTask')->name('tasks.anotherTask');
                });
            });
            Route::group(['prefix' => 'backend', 'controller' => BackendTaskController::class], function () {
                Route::post('/{id?}', 'storeTask')->name('backend.tasks.store');
                Route::delete('/{id}', 'deleteTask')->name('backend.tasks.delete');
            });
            Route::prefix('users')->group(function () {
                Route::group(['prefix' => 'backend', 'controller' => BackendTaskController::class], function () {
                    Route::post('/{id}', 'storeAssignTask')->name('backend.tasks.users.store');
                    Route::post('/copy/{id}', 'copyAnotherTask')->name('backend.tasks.users.copy');
                    Route::post('/status/{id}', 'changeStatus')->name('backend.tasks.users.status');
                    Route::delete('/{id}', 'deleteAssignUser')->name('backend.tasks.users.delete');
                    Route::post('/submit/{id}', 'submitTask')->name('backend.tasks.submit');
                });
            });
        });
    });
});
