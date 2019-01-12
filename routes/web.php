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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// ITEMS CONTROLLER //
Route::get('/items/all','ItemsController@index')->name('items');
Route::get('/item/show/{id}','ItemsController@showItem');
Route::get('/item/add','ItemsController@showAdd');
Route::post('/item/add','ItemsController@addItem');
Route::post('/item/update','ItemsController@updateItem');
Route::post('/item/delete','ItemsController@deleteItem');
Route::get('/items/search','ItemsController@search');
Route::get('/item/restock','ItemsController@showRestock');
Route::get('/item/issue','ItemsController@showIssue');
Route::post('/item/issue','ItemsController@issue');
Route::post('/item/restock','ItemsController@restock');
Route::get('/deleted-items','ItemsController@showDeleted');


// CATEGORIES CONTROLLER //
Route::get('/categories/all','CategoriesController@index')->name('categories');
Route::post('/categories/add','CategoriesController@add');



// LEDGER CONTROLLER //
Route::get('/ledger','LedgerController@index');
Route::get('/ledger/view','LedgerController@showLedgerEntry');
Route::get('/set/year','LedgerController@setSummaryYear');
Route::get('/view/all','LedgerController@viewAllFromYear');


// TEST //
//Route::get('/test','LedgerController@getTotals');

