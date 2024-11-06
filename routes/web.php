<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventsController;
use Illuminate\Support\Facades\Auth;

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

Auth::routes(['verify' => true]);

Route::get('/not-active', function(){return view('auth.not-active');})->name('not-active');

Route::middleware(['verified', 'active'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth']);
});

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->middleware('auth')->name('admin.users');
    Route::put('/admin/users/activate/{id}', [UserController::class, 'activate'])->name('users.activate');
    Route::put('/admin/users/deactivate/{id}', [UserController::class, 'deactivate'])->name('users.deactivate');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/admin/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/admin/user/{id}', [UserController::class, 'update'])->name('user.update');
});

Route::middleware(['organizer'])->group(function () {
    Route::get('/organizer/events', [EventsController::class, 'index'])->name('events.get');
    Route::get('/organizer/events/filter/{category}', [EventsController::class, 'filter'])->name('events.filter');
    Route::get('/organizer/events/create', [EventsController::class, 'createView'])->name('events.create');
    Route::post('/organizer/events/create', [EventsController::class, 'store'])->name('events.store');
    Route::get('/organizer/events/update/{id}', [EventsController::class, 'updateForm'])->name('events.updateform');
    Route::put('/organizer/events/update/{id}', [EventsController::class, 'update'])->name('events.update');
    Route::delete('/organizer/events/{event}', [EventsController::class, 'destroy'])->name('events.delete');
});


