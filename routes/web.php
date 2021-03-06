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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/links/statistic/{id}', 'RedirectLinksController@getStatistic');
    Route::resource('/links', 'RedirectLinksController')->only([
        'index', 'show', 'store', 'update', 'destroy'
    ]);

    Route::get('/home', 'HomeController@index')->name('home');
});

Route::get('/{any}', 'RedirectLinksController@checkRedirect')->where('any', '.*');