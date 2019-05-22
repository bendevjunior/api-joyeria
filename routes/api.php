<?php

use Illuminate\Http\Request;



Route::get('produto/show', "API\V1\ProdutoController@show");
Route::get('produto/list', "API\V1\ProdutoController@index");
Route::get('produto/categoria/show/{uuid}', "API\V1\ProdutoController@categoria_produto");
Route::get('produto/categoria/list', "API\V1\ProdutoController@categoria_index");
Route::get('endereco/busca-estado/', "API\V1\\EnderecoController@busca_estado");
Route::get('endereco/busca-cidade/', "API\V1\\EnderecoController@busca_cidade");

Route::get('produto/colecao/show/{uuid}', "API\V1\ProdutoController@colecao_produto");
Route::get('produto/colecao/list', "API\V1\ProdutoController@colecao_index");

Route::post('cliente/store', 'API\V1\ClienteController@store');


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

Route::group(['middleware' => 'auth:api','cors','prefix' => 'produto/categoria'], function () {
    Route::post('store', "API\V1\ProdutoController@categoria_store");
    Route::put('update', "API\V1\ProdutoController@categoria_update");
    
});

Route::group(['middleware' => 'auth:api','cors','prefix' => 'produto/colecao'], function () {
    Route::post('store', "API\V1\ProdutoController@colecao_store");
    Route::put('update', "API\V1\ProdutoController@colecao_update");
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'API\V1\authController@login');
    Route::post('register', 'API\V1\authController@register');
  
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

Route::group(['middleware' => 'auth:api','cors','prefix' => 'cliente'], function () {
    Route::put('update', 'API\V1\ClienteController@update');
    Route::get('lista', 'API\V1\ClienteController@index');
});

Route::group(['middleware' => 'auth:api','cors','prefix' => 'vendas'], function () {
    Route::get('consignado/lista', 'API\V1\ConsignadoController@index');
    Route::post('consignado/store', 'API\V1\ConsignadoController@store');
    Route::post('consignado/complete', 'API\V1\ConsignadoController@venda_consignado');

});