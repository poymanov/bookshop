<?php

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['prefix' => 'books', 'as' => 'books.'], function() {
    Route::get('{book}', 'BooksController@show')->name('show');
});

Route::group(['prefix' => 'authors', 'as' => 'authors.'], function() {
    Route::get('', 'AuthorsController@index')->name('index');
    Route::get('{author}', 'AuthorsController@show')->name('show');
});


