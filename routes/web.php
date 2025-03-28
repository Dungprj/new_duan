<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
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

Route::get('/', [ClientController::class , 'home'])->name('home');

Route::get('/introduce', [ClientController::class , 'introduce'])->name('introduce');


Route::get('/support', [ClientController::class , 'support'])->name('support');

Route::get('/category/{slug}', [ClientController::class , 'category'])->name('category');


Route::get('/detail/{category_slug}/{blog_slug}', [ClientController::class , 'detail'])->name('detail');

// Route::post('/search', [BlogController::class, 'search'])->name('search');


Route::get('/login', [AuthController::class , 'login'])->name('login');
Route::post('/login', [AuthController::class , 'logined'])->name('login.store');


Route::get('/register', [AuthController::class , 'register'])->name('register');
Route::post('/register', [AuthController::class , 'registered'])->name('register.store');

Route::post('/logout', [AuthController::class , 'logout'])->name('logout')->middleware('auth');



Route::middleware('auth')->prefix('admin')->group(function () {

    Route::resource('users', AccountController::class);
    Route::post('/users/{id}/{status}', [AccountController::class, 'status'])->name('users.status');



    Route::resource('roles', RoleController::class);




    Route::resource('categories', CategoryController::class);

    Route::resource('blogs', BlogController::class);





    Route::post('blogs/status/{id}', [BlogController::class , 'status'])->name('blogs.status');

});
