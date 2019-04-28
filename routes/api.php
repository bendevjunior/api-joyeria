<?php

use Illuminate\Http\Request;


Route::post('auth/login', "API\V1\authController@authenticate");
Route::post('auth/register', "API\V1\authController@register");

Route::get('endereco/busca-estado/', "API\V1\\EnderecoController@busca_estado");
Route::get('endereco/busca-cidade/', "API\V1\\EnderecoController@busca_cidade");

Route::group(['middleware' => 'jwt.auth', 'prefix' => 'auth'], function () {
    Route::post('ativar-conta', "API\V1\authController@ativar_conta");
});

Route::group(['middleware' => 'jwt.auth', 'prefix' => 'fornecedor'], function () {
    Route::post('store', "API\V1\FornecedorController@store");
});
