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
Route::get('/home', 'HomeController@index')->name('home');

require_once('pesquisas.route.php');
require_once('tccs.route.php');
require_once('extensao.route.php');
require_once('mestrados.route.php');
require_once('usuarios.route.php');
require_once('auth.route.php');
require_once('public.route.php');










