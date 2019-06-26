<?php

Route::group(['prefix'=>'tcc'],function(){
    Route::get('/visualizar-tcc', [
        'as'=>'visualizar_tcc',
        'uses'=>'TccController@index',
        'roles'=>['admin','professor','aluno'],
        'middleware'=>'roles'
    ]);

    Route::get('/visualizar-tcc-aluno', [
        'as'=>'visualizar_tcc_aluno',
        'uses'=>'TccController@showSingleTcc',
        'roles'=>['aluno'],
        'middleware'=>'roles'
    ]);

    Route::get('/criar-tcc', [
        'as'=>'criar_tcc',
        'uses'=>'TccController@create',
        'roles'=>['admin','aluno'],
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