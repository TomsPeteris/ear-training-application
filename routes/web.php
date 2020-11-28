<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Front\ExerciseController;
use App\Http\Controllers\Front\HistoryController;
use App\Http\Controllers\Front\StatisticsController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Front\ProfileController;
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
Route::get('/profile', [ProfileController::class, 'index'])
    ->name('profile')
    ->middleware('auth:sanctum');

Route::get('/dashboard', [HomeController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth:sanctum');

Route::get('/exercises', [ExerciseController::Class, 'index'])
    ->name('exercises')
    ->middleware('auth:sanctum');

Route::post('/exercise', [ExerciseController::class, 'exercise'])
    ->name('exercise')
    ->middleware('auth:sanctum');

Route::get('/exercises/interval', [ExerciseController::class, 'interval'])
    ->name('exercises.interval')
    ->middleware('auth:sanctum');

Route::post('/exercise/store', [ExerciseController::class, 'store'])
    ->name('exercise.store')
    ->middleware('auth:sanctum');

Route::get('/exercise/{exercise}/overview', [ExerciseController::class, 'overview'])
    ->name('exercise.overview')
    ->middleware('auth:sanctum');

Route::get('/history', [HistoryController::class, 'index'])
    ->name('history')
    ->middleware('auth:sanctum');

Route::get('/statistics', [StatisticsController::class, 'index'])
    ->name('statistics')
    ->middleware('auth:sanctum');

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

Route::post('/admin/users/store', [UserController::class, 'store'])
    ->name('users.store')
    ->middleware(['auth:sanctum', 'can:accessAdmin']);

Route::get('/admin/users/create', [UserController::class, 'create'])
    ->name('users.create')
    ->middleware(['auth:sanctum', 'can:accessAdmin']);

Route::put('/admin/users/{user}/update', [UserController::class, 'update'])
    ->name('users.update')
    ->middleware(['auth:sanctum', 'can:accessAdmin']);

Route::put('/admin/users/{user}/reset', [UserController::class, 'reset'])
    ->name('users.reset')
    ->middleware(['auth:sanctum', 'can:accessAdmin']);

Route::delete('/admin/users/{user}/destroy', [UserController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware(['auth:sanctum', 'can:accessAdmin']);

Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])
    ->name('users.edit')
    ->middleware(['auth:sanctum', 'can:accessAdmin']);

Route::get('admin/notes', [NoteController::class, 'index'])
    ->name('notes')
    ->middleware(['auth:sanctum', 'can:accessAdmin']);

Route::put('admin/notes/{note}/update', [NoteController::class, 'update'])
    ->name('notes.update')
    ->middleware(['auth:sanctum', 'can:accessAdmin']);

Route::get('admin/notes/{note}/edit', [NoteController::class, 'edit'])
    ->name('notes.edit')
    ->middleware(['auth:sanctum', 'can:accessAdmin']);

