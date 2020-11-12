<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [HomeController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth:sanctum', 'verified']);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin', [AdminController::class, 'index'])
    ->name('admin')
    ->middleware(['auth:sanctum', 'can:accessAdmin']);

Route::get('/admin/users', [UserController::class, 'index'])
    ->name('users')
    ->middleware(['auth:sanctum', 'can:accessAdmin']);

Route::post('/admin/users', [UserController::class, 'store'])
    ->name('users.store')
    ->middleware(['auth:sanctum', 'can:accessAdmin']);

Route::get('/admin/users/create', [UserController::class, 'create'])
    ->name('users.create')
    ->middleware(['auth:sanctum', 'can:accessAdmin']);

Route::put('/admin/users/{user}', [UserController::class, 'update'])
    ->name('users.update')
    ->middleware(['auth:sanctum', 'can:accessAdmin']);

Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware(['auth:sanctum', 'can:accessAdmin']);

Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])
    ->name('users.edit')
    ->middleware(['auth:sanctum', 'can:accessAdmin']);
