<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check() 
        ? redirect('/admin/dashboard') 
        : redirect('/login');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Users
        Route::get('/users', [UserController::class, 'index'])
            ->name('users.index');

        Route::put('/users/{user}/role', [UserController::class, 'updateRole'])
            ->name('users.role');

        // Categories (CRUD)
        Route::resource('categories', CategoryController::class)
            ->except(['create', 'edit', 'show']);

        Route::patch('/categories/{category}/toggle', 
            [CategoryController::class, 'toggleStatus']
        )->name('categories.toggle');

        // Menus (FULL BACKEND)


        Route::resource('menus', MenuController::class)
            ->except(['show', 'create', 'edit']);

        Route::patch('menus/{menu}/toggle', 
            [MenuController::class, 'toggle']
        )->name('menus.toggle');
    });

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
