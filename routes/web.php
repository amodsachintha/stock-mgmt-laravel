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
Route::post('/item/update','ItemsController@updateItem');
Route::post('/item/delete','ItemsController@deleteItem');

// CATEGORIES CONTROLLER //
Route::get('/categories/all','CategoriesController@index');
Route::post('/categories/add','CategoriesController@add');


// LEDGER CONTROLLER //
Route::get('/ledger','LedgerController@index');

// TEST //
Route::get('/test','LedgerController@getTotals');

