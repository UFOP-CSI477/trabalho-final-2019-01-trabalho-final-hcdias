<?php 
Route::group(['prefix'=>'mestrado'],function(){
    Route::get('/visualizar-mestrado', [
        'as'=>'visualizar_mestrado',
        'uses'=>'MestradoController@index',
        'roles'=>['admin','professor','aluno'],
        'middleware'=>'roles'
    ]);

    Route::get('/criar-mestrado', [
        'as'=>'criar_mestrado',
        'uses'=>'MestradoController@create',
        'roles'=>['admin','professor','aluno'],
        'middleware'=>'roles'
    ]);

    Route::get('/detalhar-mestrado/{id}',[
        'as'=>'detalhar_mestrado',
        'uses'=> 'MestradoController@show',
        'roles'=>['admin','professor','aluno'],
        'middleware'=>'roles'
    ]);

    Route::post('/salvar-mestrado', [
        'as'=>'salvar_mestrado',
        'uses'=>'MestradoController@store',
        'roles'=>['admin','professor','aluno'],
        'middleware'=>'roles'
    ]);

    Route::get('/editar-mestrado/{id}', [
        'as'=>'editar_mestrado',
        'uses'=>'MestradoController@edit',
        'roles'=>['admin','professor','aluno'],
        'middleware'=>'roles'
    ]);

    Route::post('/atualizar-mestrado/{id}', [
        'as'=>'atualizar_mestrado',
        'uses'=>'MestradoController@update',
        'roles'=>['admin','professor','aluno'],
        'middleware'=>'roles'
    ]);
    Route::get('/delete/{id}', [
        'as'=>'deletar_mestrado',
        'uses'=>'MestradoController@destroy',
        'roles'=>['admin','professor','aluno'],
        'middleware'=>'roles'
    ]);
});