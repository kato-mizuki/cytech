<?php

use App\Http\Controllers\ProductController;

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
//Route::get('/', 'LoginController@')->name('list');

Route::get('/list', 'ProductController@index')->name('list');

Route::get('/search', 'ProductController@search')->name('search');

Route::get('/create', 'ProductController@create')->name('create');

Route::post('/list', 'ProductController@store')->name('store');

Route::get('/list/{product}', 'ProductController@show')->name('show');

Route::get('/edit/{product}', 'ProductController@edit')->name('edit');

Route::put('/list/{product}', 'ProductController@update')->name('update');

// Route::delete('/list/{product}', 'ProductController@destroy')->name('destroy');

Route::post('/delete', 'ProductController@destroy')->name('destroy');


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');