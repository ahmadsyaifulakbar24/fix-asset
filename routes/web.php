<?php

use App\Http\Controllers\AssetRequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardControler;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['guest'])->group(function() {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login-action', [AuthController::class, 'login_action'])->name('login.action');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardControler::class, 'index'])->name('dashboard');
    
    Route::prefix('category')->controller(CategoryController::class)->group(function() {
        Route::get('/', 'index')->name('category');
        Route::get('/create', 'create')->name('category.create');
        Route::post('/', 'store')->name('category.store');
        Route::get('/{category:id}/edit', 'edit')->name('category.edit');
        Route::put('/{category:id}', 'update')->name('category.update');
        Route::delete('/{category:id}', 'destroy')->name('category.destroy');
    });
    
    Route::prefix('department')->controller(DepartmentController::class)->group(function() {
        Route::get('/', 'index')->name('department');
        Route::get('/create', 'create')->name('department.create');
        Route::post('/', 'store')->name('department.store');
        Route::get('/{department:id}/edit', 'edit')->name('department.edit');
        Route::put('/{department:id}', 'update')->name('department.update');
        Route::delete('/{department:id}', 'destroy')->name('department.destroy');
    });
    
    Route::prefix('office')->controller(OfficeController::class)->group(function() {
        Route::get('/', 'index')->name('office');
        Route::get('/create', 'create')->name('office.create');
        Route::post('/', 'store')->name('office.store');
        Route::get('/{office:id}/edit', 'edit')->name('office.edit');
        Route::put('/{office:id}', 'update')->name('office.update');
        Route::delete('/{office:id}', 'destroy')->name('office.destroy');
    });
    
    Route::prefix('user')->controller(UserController::class)->group(function() {
        Route::get('/', 'index')->name('user');
        Route::get('/create', 'create')->name('user.create');
        Route::post('/', 'store')->name('user.store');
        Route::get('/{user:id}/edit', 'edit')->name('user.edit');
        Route::put('/{user:id}', 'update')->name('user.update');
        Route::delete('/{user:id}', 'destroy')->name('user.destroy');
    });
    
    Route::prefix('asset_request')->controller(AssetRequestController::class)->group(function() {
        Route::get('/', 'index')->name('asset_request');
        Route::get('/create', 'create')->name('asset_request.create');
        Route::post('/', 'store')->name('asset_request.store');
        Route::get('/{asset_request:id}', 'show')->name('asset_request.show');
        Route::get('/{asset_request:id}/edit', 'edit')->name('asset_request.edit');
        Route::put('/{asset_request:id}', 'update')->name('asset_request.update');
        Route::delete('/{asset_request:id}', 'destroy')->name('asset_request.destroy');
        Route::post('/{asset_request:id}/submit', 'submit')->name('asset_request.submit');

        Route::prefix('/{asset_request:id}')->group(function() {
            Route::get('/create', 'asset_request_create')->name('sub_asset_request.create');
            Route::post('/', 'asset_request_store')->name('sub_asset_request.store');
            Route::get('/{sub_asset_request:id}/edit', 'asset_request_edit')->name('sub_asset_request.edit');
            Route::put('/{sub_asset_request:id}', 'asset_request_update')->name('sub_asset_request.update');
            Route::delete('/{sub_asset_request:id}', 'asset_request_destroy')->name('sub_asset_request.destroy');
        });

        Route::prefix('/{asset_request:id}/file')->group(function() {
            Route::get('/create', 'file_create')->name('file_asset_request.create');
            Route::post('/', 'file_store')->name('file_asset_request.store');
            Route::delete('/{file:id}', 'file_destroy')->name('file_asset_request.destroy');
        });
    });
});