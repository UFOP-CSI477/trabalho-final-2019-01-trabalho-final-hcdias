<?php
Route::get('/', 'HomeController@exibir')->name('index');
Route::post('/resultados', 'HomeController@pesquisar')->name('exibir_resultados');
Route::get('/resultados', 'HomeController@exibir');