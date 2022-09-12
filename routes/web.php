<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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



Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/get-user-data/{type}', [UserController::class, 'show'])->name('get-user-data');
Route::get('/sent-request/{userId}', [UserController::class, 'sentRequest'])->name('sent-request');
Route::get('/cancel-request/{userId}', [UserController::class, 'cancelRequest'])->name('cancel-request');
Route::get('/accept-request/{userId}', [UserController::class, 'acceptRequest'])->name('accept-request');
Route::get('/remove-connection/{userId}', [UserController::class, 'removeConnection'])->name('remove-connection');
Route::get('/common-connection/{userId}', [UserController::class, 'commonConnection'])->name('common-connection');
