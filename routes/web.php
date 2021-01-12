<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
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
    return auth()->guest()
        ? redirect()->route('login')
        : redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'login'])
    ->name('login');

Route::get('/register', [AuthController::class, 'register'])
    ->name('register');

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
*/
Route::get('/profile', [ProfileController::class, 'index'])
    ->name('profile')
    ->middleware('auth');

Route::put('/profile/update-information', [ProfileController::class, 'updateProfileInformation'])
    ->name('profile.update-information')
    ->middleware('auth');

Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])
    ->name('profile.update-password')
    ->middleware('auth');

Route::delete('/profile', [ProfileController::class, 'deleteProfile'])
    ->name('profile.delete')
    ->middleware('auth');

Route::get('/dashboard', [HomeController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

Route::get('/exercise', [ExerciseController::Class, 'index'])
    ->name('exercise')
    ->middleware('auth');

Route::post('/exercise/interval', [ExerciseController::class, 'execute'])
    ->name('exercise.execute')
    ->middleware('auth');

Route::get('/exercise/interval', [ExerciseController::class, 'interval'])
    ->name('exercise.interval')
    ->middleware('auth');

Route::post('/exercise/store', [ExerciseController::class, 'store'])
    ->name('exercise.store')
    ->middleware('auth');

Route::get('/history', [HistoryController::class, 'index'])
    ->name('history')
    ->middleware('auth');

Route::get('/history/{exercise}/overview', [HistoryController::class, 'overview'])
    ->name('history.overview')
    ->middleware(['auth', 'can:accessOverview,exercise']);

Route::get('/statistics', [StatisticsController::class, 'index'])
    ->name('statistics')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin', [AdminController::class, 'index'])
    ->name('admin')
    ->middleware(['auth', 'can:accessAdmin']);

Route::get('/admin/users', [UserController::class, 'index'])
    ->name('users')
    ->middleware(['auth', 'can:accessAdmin']);

Route::post('/admin/users/store', [UserController::class, 'store'])
    ->name('users.store')
    ->middleware(['auth', 'can:accessAdmin']);

Route::get('/admin/users/create', [UserController::class, 'create'])
    ->name('users.create')
    ->middleware(['auth', 'can:accessAdmin']);

Route::put('/admin/users/{user}/update', [UserController::class, 'update'])
    ->name('users.update')
    ->middleware(['auth', 'can:accessAdmin']);

Route::delete('/admin/users/{user}/destroy', [UserController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware(['auth', 'can:accessAdmin']);

Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])
    ->name('users.edit')
    ->middleware(['auth', 'can:accessAdmin']);

Route::get('admin/notes', [NoteController::class, 'index'])
    ->name('notes')
    ->middleware(['auth', 'can:accessAdmin']);

Route::put('admin/notes/{note}/update', [NoteController::class, 'update'])
    ->name('notes.update')
    ->middleware(['auth', 'can:accessAdmin']);

Route::get('admin/notes/{note}/edit', [NoteController::class, 'edit'])
    ->name('notes.edit')
    ->middleware(['auth', 'can:accessAdmin']);

