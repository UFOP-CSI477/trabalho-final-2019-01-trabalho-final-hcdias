<?php 
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

    Route::post('/salvar-perfil', [
        'as'=>'salvar_perfil',
        'uses'=>'UserController@storeProfilePicture',
        'roles'=>['admin','professor', 'aluno'],
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

    Route::get('/meu-perfil/', [
        'as'=>'meu_perfil',
        'uses'=>'UserController@show',
        'roles'=>['admin', 'professor', 'aluno'],
        'middleware'=>'roles'
        ]);
});