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
    Route::post('upload', 'UploadController@images');
});

Route::get('plantas', 'PlantasController@index');
Route::group(['prefix' => 'search'], function() {
    Route::get('plantas', 'PlantasController@searchByName');
    Route::get('publicaciones', 'PlantacionesController@searchBy');
});
Route::post('validate/email', 'UserController@validateEmail');
