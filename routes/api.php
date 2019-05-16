<?php

use Illuminate\Http\Request;



Route::get('produto/show', "API\V1\ProdutoController@show");
Route::get('produto/list', "API\V1\ProdutoController@index");
Route::get('endereco/busca-estado/', "API\V1\\EnderecoController@busca_estado");
Route::get('endereco/busca-cidade/', "API\V1\\EnderecoController@busca_cidade");




Route::group(['middleware' => 'auth:api', 'cors','prefix' => 'fornecedor'], function () {
    Route::post('store', "API\V1\FornecedorController@store");
    Route::get('show', "API\V1\FornecedorController@show");
    Route::post('update', "API\V1\FornecedorController@update");
});

Route::group(['middleware' => 'auth:api', 'cors', 'prefix' => 'produto'], function () {
    Route::post('store', "API\V1\ProdutoController@store");
    Route::post('foto/store', "API\V1\ProdutoController@store_foto");
    Route::post('store_update', "API\V1\ProdutoController@store_update_fornecedor");
    Route::delete('foto/delete', "API\V1\ProdutoController@destroy_foto");
});

Route::group(['middleware' => 'auth:api','cors','prefix' => 'produto/compra'], function () {
    Route::post('store', "API\V1\ProdutoCompraController@store");
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'API\V1\authController@login');
    Route::post('signup', 'API\V1\authController@signup');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'API\V1\authController@logout');
        Route::get('user', 'API\V1\authController@user');
        Route::get('user/list', 'API\V1\authController@user_list');
        Route::post('ativar-conta', "API\V1\authController@ativar_conta");
    });
});

Route::group(['middleware' => 'auth:api','cors','prefix' => 'dashboard'], function () {
    Route::get('count/{mes?}/{ano?}', "API\V1\DashboardController@dashboard_count");
});