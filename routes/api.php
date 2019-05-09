<?php

use Illuminate\Http\Request;


Route::post('auth/login', "API\V1\authController@authenticate");
Route::post('auth/register', "API\V1\authController@register");
Route::get('produto/show', "API\V1\ProdutoController@show");
Route::get('produto/list', "API\V1\ProdutoController@index");
Route::get('endereco/busca-estado/', "API\V1\\EnderecoController@busca_estado");
Route::get('endereco/busca-cidade/', "API\V1\\EnderecoController@busca_cidade");


Route::group(['middleware' => 'jwt.auth', 'prefix' => 'auth'], function () {
    Route::post('ativar-conta', "API\V1\authController@ativar_conta");
});

Route::group(['middleware' => 'jwt.auth', 'cors','prefix' => 'fornecedor'], function () {
    Route::post('store', "API\V1\FornecedorController@store");
    Route::get('show', "API\V1\FornecedorController@show");
    Route::post('update', "API\V1\FornecedorController@update");
});

Route::group(['middleware' => 'jwt.auth', 'cors', 'prefix' => 'produto'], function () {
    Route::post('store', "API\V1\ProdutoController@store");
    Route::post('store_update', "API\V1\ProdutoController@store_update_fornecedor");
});

Route::group(['middleware' => 'jwt.auth','cors','prefix' => 'produto/compra'], function () {
    Route::post('store', "API\V1\ProdutoCompraController@store");
});