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
Route::get('/exibir', 'HomeController@exibir')->name('exibir');
Route::post('/exibir', 'HomeController@exibir')->name('exibir');

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
		'roles'=>['admin','professor','aluno'],
		'middleware'=>'roles'
	]);

	Route::post('/salvar-pesquisa', [
		'as'=>'salvar_pesquisa',
		'uses'=>'PesquisaController@store',
		'roles'=>['admin','professor','aluno'],
		'middleware'=>'roles'
	]);

	Route::get('/editar-pesquisa/{id}', [
		'as'=>'editar_pesquisa',
		'uses'=>'PesquisaController@edit',
		'roles'=>['admin','professor','aluno'],
		'middleware'=>'roles'
	]);

	Route::post('/atualizar-pesquisa/{id}', [
		'as'=>'atualizar_pesquisa',
		'uses'=>'PesquisaController@update',
		'roles'=>['admin','professor','aluno'],
		'middleware'=>'roles'
	]);

	Route::get('/delete/{id}', [
		'as'=>'deletar_pesquisa',
		'uses'=>'PesquisaController@destroy',
		'roles'=>['admin','professor'],
		'middleware'=>'roles'
	]);
});

Route::group(['prefix'=>'tcc'],function(){
	Route::get('/visualizar-tcc', [
		'as'=>'visualizar_tcc',
		'uses'=>'TccController@index',
		'roles'=>['admin','professor','aluno'],
		'middleware'=>'roles'
	]);

	Route::get('/criar-tcc', [
		'as'=>'criar_tcc',
		'uses'=>'TccController@create',
		'roles'=>['admin','professor','aluno'],
		'middleware'=>'roles'
	]);

	Route::get('/detalhar-tcc/{id}',[
		'as'=>'detalhar_tcc',
		'uses'=> 'TccController@show',
		'roles'=>['admin','professor','aluno'],
		'middleware'=>'roles'
	]);

	Route::post('/salvar-tcc', [
		'as'=>'salvar_tcc',
		'uses'=>'TccController@store',
		'roles'=>['admin','professor','aluno'],
		'middleware'=>'roles'
	]);

	Route::get('/editar-tcc/{id}', [
		'as'=>'editar_tcc',
		'uses'=>'TccController@edit',
		'roles'=>['admin','professor','aluno'],
		'middleware'=>'roles'
	]);

	Route::post('/atualizar-tcc/{id}', [
		'as'=>'atualizar_tcc',
		'uses'=>'TccController@update',
		'roles'=>['admin','professor','aluno'],
		'middleware'=>'roles'
	]);
	Route::get('/delete/{id}', [
		'as'=>'deletar_tcc',
		'uses'=>'TccController@destroy',
		'roles'=>['admin','professor','aluno'],
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
