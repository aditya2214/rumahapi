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

Route::get('/index.html', function () {
    $produk = \App\Produk::all();
    return view('welcome',compact('produk'));
});
Route::get('/logout', function () {
    Auth::logout();
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// frontend
Route::post('/save-pembeli', 'DataPembeliController@store');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
