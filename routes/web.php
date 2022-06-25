<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExternalController;
use App\Http\Controllers\InController;
use App\Http\Controllers\OutController;

Route::middleware(['auth','isActive'])->group(function () {

Route::get('/', function () { return view('dashboard');})->name('home');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/notifications', [AuthController::class, 'notifications'])->name('notifications');
Route::get('/notificationsData', [AuthController::class, 'notificationsData'])->name('notificationsData');

Route::resource('users', UserController::class);

Route::resource('items', ItemController::class);
Route::get('/itemsData', [ItemController::class, 'itemsData'])->name('itemsData');

Route::resource('suppliers', SupplierController::class);
Route::resource('externals', ExternalController::class);
Route::resource('in', InController::class);
Route::resource('out', OutController::class);

Route::post('/select2-autocomplete-ajax', [ItemController::class, 'dataAjax'])->name('/select2-autocomplete-ajax');

});

Route::get('/login', function () { return view('login');})->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');


