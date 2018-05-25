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

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/visualizar-pesquisa', 'PesquisaController@index')->name('view');
Route::get('/criar-pesquisa', 'PesquisaController@create')->name('create');
Route::get('/detalhar-pesquisa', 'PesquisaController@show')->name('show');
Route::post('/salvar-pesquisa', 'PesquisaController@store')->name('salvar_pesquisa');

