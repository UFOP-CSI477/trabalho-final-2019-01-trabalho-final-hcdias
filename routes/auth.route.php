<?php
Route::get('/login','Auth\MinhaUfopLoginController@showLoginUfop')->name('login');
Route::post('/login','Auth\MinhaUfopLoginController@login')->name('minhaufop_login_submit');

Route::post('/logout','Auth\MinhaUfopLoginController@logout')->name('minhaufop_logout_submit');

Route::get('/admin/login','Auth\LoginController@showLoginForm')->name('admin_login');
Route::post('/admin/login','Auth\LoginController@login')->name('admin_login_submit');
Route::post('/admin/logout','Auth\LoginController@logout')->name('admin_logout');