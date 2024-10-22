<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin/users', [UserController::class, 'index'])->middleware('auth', 'admin');
Route::put('/admin/users/activate/{id}', [UserController::class, 'activate'])->name('users.activate');
Route::put('/admin/users/deactivate/{id}', [UserController::class, 'deactivate'])->name('users.deactivate');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

