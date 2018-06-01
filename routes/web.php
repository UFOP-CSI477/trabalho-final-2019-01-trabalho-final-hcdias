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

Route::get('/visualizar-pesquisa', [
	'as'=>'visualizar_pesquisas',
	'uses'=>'PesquisaController@index',
	'roles'=>'admin',
	'middleware'=>'roles'
	]);

Route::get('/criar-pesquisa', 'PesquisaController@create')->name('create');
Route::get('/detalhar-pesquisa/{id}', 'PesquisaController@show')->name('detalhar_pesquisa');
Route::post('/salvar-pesquisa', 'PesquisaController@store')->name('salvar_pesquisa');
Route::get('/editar-pesquisa/{id}', 'PesquisaController@edit')->name('editar_pesquisa');

