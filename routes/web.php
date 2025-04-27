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

// Frontpage
Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::prefix('auth')->group(function () {
    // Frontend Auth
    Route::get('/login', [FrontendAuthController::class, 'login'])->name('login');

    // Backend Auth
    Route::prefix('backend')->controller(BackendAuthController::class)->group(function () {
        Route::post('/login', 'login')->name('backend.login');
        Route::post('/logout', 'logout')->name('backend.logout');
    });
});

// Route setelah login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Backend Routes (Ditaruh di atas Frontend Routes)
    |--------------------------------------------------------------------------
    */

    // Backend Users
    Route::prefix('users/backend')->controller(UserController::class)->group(function () {
        Route::get('/', 'getUser')->name('backend.users');
        Route::post('/{id?}', 'storeUser')->name('backend.users.store');
        Route::delete('/{id}', 'deleteUser')->name('backend.users.delete');
    });

    // Backend Jobs
    Route::prefix('jobs/backend')->controller(BackendJobController::class)->group(function () {
        Route::post('/{id?}', 'storeJob')->name('backend.jobs.store');
        Route::delete('/{id}', 'deleteJob')->name('backend.jobs.delete');
    });

    // Backend Tasks
    Route::prefix('jobs/tasks/backend')->controller(BackendTaskController::class)->group(function () {
        Route::get('/', 'getTask')->name('backend.tasks');
        Route::post('/{id?}', 'storeTask')->name('backend.tasks.store');
        Route::delete('/{id}', 'deleteTask')->name('backend.tasks.delete');
    });

    // Backend Tasks Users
    Route::prefix('jobs/tasks/users/backend')->controller(BackendTaskController::class)->group(function () {
        Route::post('/{id}', 'storeAssignTask')->name('backend.tasks.users.store');
        Route::post('/copy/{id}', 'copyAnotherTask')->name('backend.tasks.users.copy');
        Route::post('/status/{id}', 'changeStatus')->name('backend.tasks.users.status');
        Route::post('/submit/{id}', 'submitTask')->name('backend.tasks.submit');
        Route::delete('/{id}', 'deleteAssignUser')->name('backend.tasks.users.delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Frontend Routes (Ditaruh setelah Backend Routes)
    |--------------------------------------------------------------------------
    */

    // Frontend Jobs
    Route::prefix('jobs')->controller(FrontendJobController::class)->group(function () {
        Route::get('/store/{id}', 'modalStoreJob')->name('jobs.storeJob');
        Route::get('/task/{id}', 'modalNewTask')->name('jobs.newTask');
        Route::get('/{id}', 'detail')->name('jobs.detail');
    });

    // Frontend Tasks
    Route::prefix('jobs/tasks')->controller(FrontendTaskController::class)->group(function () {
        Route::get('/store/{id}', 'modalStoreTask')->name('tasks.storeTask');
        Route::get('/{id}', 'detail')->name('tasks.detail');
    });

    // Frontend Tasks Users
    Route::prefix('jobs/tasks/users')->controller(FrontendTaskController::class)->group(function () {
        Route::get('/choose/{id}', 'modalAnotherTask')->name('tasks.anotherTask');
        Route::get('/{id}', 'modalNewUser')->name('tasks.newUser');
    });

});
