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

Route::get('/home', 'HomeController@index')->name('home');


// ITEMS CONTROLLER //
Route::get('/items/all','ItemsController@index');
Route::get('/item/show/{id}','ItemsController@showItem');

// CATEGORIES CONTROLLER //
//Route::get('/categories/all')


// LEDGER CONTROLLER //
Route::get('/ledger','LedgerController@index');

// TEST //
Route::get('/test','LedgerController@getTotals');

