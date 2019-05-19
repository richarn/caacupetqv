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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('inicio', 'InicioController@index');

Route::get('registro/plantacion', 'RegistroPlantacionController@index');

Route::get('registro/planta', 'RegistroPlantaController@index');

Route::get('zona', 'ZonaController@index');

