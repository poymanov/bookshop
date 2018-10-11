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

Route::group(['prefix' => '/admin', 'namespace' => 'Admin', 'as' => 'admin.'], function() {
    Route::get('', 'DashboardController@index')->name('index');

    Route::group(['prefix' => 'authors', 'as' => 'authors.'], function() {
        Route::get('', 'AuthorsController@index')->name('index');
        Route::post('', 'AuthorsController@store')->name('store');
        Route::get('create', 'AuthorsController@create')->name('create');
        Route::get('{author}/edit', 'AuthorsController@edit')->name('edit');
        Route::patch('{author}', 'AuthorsController@update')->name('update');
        Route::delete('{author}', 'AuthorsController@destroy')->name('destroy');
        Route::get('{author}', 'AuthorsController@show')->name('show');
    });
});
