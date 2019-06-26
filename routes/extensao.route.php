<?php
Route::group(['prefix'=>'extensao'],function(){
    Route::get('/visualizar-extensao', [
        'as'=>'visualizar_extensao',
        'uses'=>'ExtensaoController@index',
        'roles'=>['admin','professor','aluno'],
        'middleware'=>'roles'
    ]);

    Route::get('/criar-extensao', [
        'as'=>'criar_extensao',
        'uses'=>'ExtensaoController@create',
        'roles'=>['admin','professor'],
        'middleware'=>'roles'
    ]);

    Route::get('/detalhar-extensao/{id}',[
        'as'=>'detalhar_extensao',
        'uses'=> 'ExtensaoController@show',
        'roles'=>['admin','professor','aluno'],
        'middleware'=>'roles'
    ]);

    Route::post('/salvar-extensao', [
        'as'=>'salvar_extensao',
        'uses'=>'ExtensaoController@store',
        'roles'=>['admin','professor','aluno'],
        'middleware'=>'roles'
    ]);

    Route::get('/editar-extensao/{id}', [
        'as'=>'editar_extensao',
        'uses'=>'ExtensaoController@edit',
        'roles'=>['admin','professor','aluno'],
        'middleware'=>'roles'
    ]);

    Route::post('/atualizar-extensao/{id}', [
        'as'=>'atualizar_extensao',
        'uses'=>'ExtensaoController@update',
        'roles'=>['admin','professor','aluno'],
        'middleware'=>'roles'
    ]);
    Route::get('/delete/{id}', [
        'as'=>'deletar_tcc',
        'uses'=>'ExtensaoController@destroy',
        'roles'=>['admin','professor','aluno'],
        'middleware'=>'roles'
    ]);
});