<?php

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