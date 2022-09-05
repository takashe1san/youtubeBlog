<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::group([
    'prefix'     => 'dashboard',
    'as'         => 'dashboard.',
    'middleware' => ['auth','checkLogin'],
    ],function () {
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('index');

    Route::get('settings', function() {
        return view('dashboard.settings');
    })->name('settings');

    Route::post('settings/update/{setting}', [SettingController::class, 'update'])->name('settings.update');
    
    Route::get('users/all', [UserController::class, 'getUsers'])->name('users.all');
    Route::post('users/delete', [UserController::class, 'delete'])->name('users.delete');

    Route::get('category/all', [CategoryController::class, 'getCategories'])->name('category.all');
    Route::post('category/delete', [CategoryController::class, 'delete'])->name('category.delete');
    
    Route::get('post/all', [CategoryController::class, 'getCategories'])->name('category.all');
    Route::post('post/delete', [CategoryController::class, 'delete'])->name('category.delete');

    Route::resources([
        'category' => CategoryController::class,
        'users'    => UserController::class,
        'post'     => PostController::class,
    ]);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
