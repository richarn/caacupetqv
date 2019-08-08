<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::get('user/list', 'UserController@userList');
    Route::delete('user/{id}', 'UserController@deleteUser');
    Route::resource('plantas', 'PlantasController');
    Route::resource('zonas', 'ZonasController');
    Route::resource('publicaciones', 'PlantacionesController');
    Route::resource('roles', 'RolesController');
    Route::group(['prefix' => 'search'], function() {
        Route::get('zonas', 'ZonasController@searchByName');
        Route::get('roles', 'RolesController@searchByName');
        Route::get('usuarios', 'UserController@searchByName');
    });
});

Route::get('plantas', 'PlantasController@index');
Route::get('search/plantas', 'PlantasController@searchByName');
Route::post('validate/email', 'UserController@validateEmail');
