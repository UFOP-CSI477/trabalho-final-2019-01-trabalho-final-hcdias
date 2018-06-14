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

Route::group(['prefix'=>'pesquisa'],function(){
	Route::get('/visualizar-pesquisa', [
		'as'=>'visualizar_pesquisas',
		'uses'=>'PesquisaController@index',
		'roles'=>['admin','professor','aluno'],
		'middleware'=>'roles'
		]);

	Route::get('/criar-pesquisa', [
		'as'=>'criar_pesquisa',
		'uses'=>'PesquisaController@create',
		'roles'=>['admin','professor'],
		'middleware'=>'roles'
		]);

	Route::get('/detalhar-pesquisa/{id}',[
		'as'=>'detalhar_pesquisa',
		'uses'=> 'PesquisaController@show',
		'roles'=>['admin','professor'],
		'middleware'=>'roles'
		]);

	Route::post('/salvar-pesquisa', [
		'as'=>'salvar_pesquisa',
		'uses'=>'PesquisaController@store',
		'roles'=>['admin','professor'],
		'middleware'=>'roles'
		]);

	Route::get('/editar-pesquisa/{id}', [
		'as'=>'editar_pesquisa',
		'uses'=>'PesquisaController@edit',
		'roles'=>['admin','professor'],
		'middleware'=>'roles'
		]);
});

Route::group(['prefix'=>'usuario'],function(){
	Route::get('/visualizar-usuario', [
		'as'=>'visualizar_usuario',
		'uses'=>'UserController@index',
		'roles'=>'admin',
		'middleware'=>'roles'
		]);

	Route::get('/criar-usuario', [
		'as'=>'criar_usuario',
		'uses'=>'UserController@create',
		'roles'=>'admin',
		'middleware'=>'roles'
		]);

	Route::post('/salvar-usuario', [
		'as'=>'salvar_usuario',
		'uses'=>'UserController@store',
		'roles'=>'admin',
		'middleware'=>'roles'
		]);

	Route::get('/editar-usuario/{id}', [
		'as'=>'editar_usuario',
		'uses'=>'UserController@edit',
		'roles'=>'admin',
		'middleware'=>'roles'
		]);

	Route::post('/alterar-usuario/{id}', [
		'as'=>'alterar_usuario',
		'uses'=>'UserController@update',
		'roles'=>'admin',
		'middleware'=>'roles'
		]);

	Route::get('/remover-usuario/{id}', [
		'as'=>'remover_usuario',
		'uses'=>'UserController@destroy',
		'roles'=>'admin',
		'middleware'=>'roles'
		]);

	Route::get('/vinculo-usuario/{id}', [
		'as'=>'vinculo_usuario',
		'uses'=>'UserController@listaAtores',
		'roles'=>'admin',
		'middleware'=>'roles'
		]);
});
