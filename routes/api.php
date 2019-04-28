<?php

use Illuminate\Http\Request;


Route::post('auth/login', "API\V1\authController@authenticate");
Route::post('auth/register', "API\V1\authController@register");

Route::get('endereco/busca-estado/', "API\V1\\EnderecoController@busca_estado");
Route::get('endereco/busca-cidade/', "API\V1\\EnderecoController@busca_cidade");

Route::group(['middleware' => 'jwt.auth', 'prefix' => 'empresas'], function () {

    Route::get('lista', "API\V1\\empresaController@get_lista_de_empresas");

});
