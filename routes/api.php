<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth', 'as' => 'api.auth.'], function () {
    Route::post('login', 'Api\AuthController@login')->name('login');
    Route::get('logout', 'Api\AuthController@logout')->name('logout');
});

Route::group(['prefix' => 'books', 'as' => 'api.books.'], function () {
    Route::get('', 'Api\BooksController@index')->name('index');
    Route::get('{book}', 'Api\BooksController@show')->name('show');
    Route::patch('{book}', 'Api\BooksController@update')->name('update');
    Route::post('', 'Api\BooksController@store')->name('store');
    Route::delete('{book}', 'Api\BooksController@destroy')->name('destroy');
});

Route::group(['prefix' => 'authors', 'as' => 'api.authors.'], function () {
    Route::get('', 'Api\AuthorsController@index')->name('index');
    Route::get('{author}/books', 'Api\AuthorsController@books')->name('books');
    Route::get('{author}', 'Api\AuthorsController@show')->name('show');
    Route::patch('{author}', 'Api\AuthorsController@update')->name('update');
    Route::post('', 'Api\AuthorsController@store')->name('store');
    Route::delete('{author}', 'Api\AuthorsController@destroy')->name('destroy');
});
