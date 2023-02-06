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

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'web_index']);
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
Route::get('/user/view/{id}', [App\Http\Controllers\UserController::class, 'view']);
Route::post('/user/edit', [App\Http\Controllers\UserController::class, 'update']);
Route::get('/users/change_status/{id}/{status}', [App\Http\Controllers\UserController::class, 'status']);

Route::get('/events', [App\Http\Controllers\EventController::class, 'index'])->name('events');
Route::get('/events/view/{id}', [App\Http\Controllers\EventController::class, 'view'])->name('view');
Route::post('/event/edit', [App\Http\Controllers\EventController::class, 'update']);
Route::get('/events/change_status/{id}/{status}', [App\Http\Controllers\EventController::class, 'status']);
// Route::group(['middleware' => ['auth','nobuz']], function() {

// Route::resource('users', App\Http\Controllers\UserController::class);

// });

