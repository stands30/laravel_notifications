<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('home');

Route::resource('users', App\Http\Controllers\UserController::class);
Route::post('/mark-as-read', 'App\Http\Controllers\UserController@markNotification')->name('markNotification');
Route::post('/post-notification', 'App\Http\Controllers\UserController@postNotification')->name('postNotification');
Route::resource('notification', App\Http\Controllers\NotificationController::class);
