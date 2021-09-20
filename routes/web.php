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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/blank', function () {
    return view('blank');
})->name('blank');

Route::middleware('auth')->group(function() {
    Route::post('/store', 'HomeController@store')->name('store');
});

Route::name('admin.')->middleware(['auth', 'can:admin'])->prefix('admin')->group(function() {
    Route::get('/posisi', 'AdminController@posisi')->name('posisi');
    Route::post('/posisi', 'AdminController@posisi');
    Route::get('/pengumuman', 'AdminController@pengumuman')->name('pengumuman');
    Route::post('/pengumuman', 'AdminController@pengumuman');
    Route::get('/tasks', 'AdminController@tasks')->name('tasks');
    Route::post('/tasks', 'AdminController@tasks');
});

Route::name('member.')->middleware(['auth', 'can:member'])->prefix('member')->group(function() {
    Route::get('/konsumen', 'KaryawanController@konsumen')->name('konsumen');
    Route::post('/konsumen', 'KaryawanController@konsumen');
});
