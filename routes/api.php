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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', "API\V1\authController@authenticate");
Route::post('auth/register', "API\V1\authController@register");
Route::post('endereco/store', "API\V1\\enderecoController@store_endereco");

Route::group(['middleware' => 'jwt.auth', 'prefix' => 'empresas'], function () {

    Route::get('lista', "API\V1\\empresaController@get_lista_de_empresas");

});
