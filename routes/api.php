<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('produto/show', "API\V1\ProdutoController@show");
Route::get('produto/{nome}', "API\V1\ProdutoController@mostrar");
Route::get('produto/list', "API\V1\ProdutoController@index");
Route::get('produto/categoria/show/{uuid}', "API\V1\ProdutoController@categoria_produto");
Route::get('produto/categoria/list', "API\V1\ProdutoController@categoria_index");
Route::get('endereco/busca-estado/', "API\V1\\EnderecoController@busca_estado");
Route::get('endereco/busca-cidade/', "API\V1\\EnderecoController@busca_cidade");
Route::get('colecao-com-produto/list', "API\V1\ProdutoController@colecao_com_produto_list");

Route::get('produto/colecao/show/{nome}', "API\V1\ProdutoController@colecao_produto");
Route::get('produto/colecao/list', "API\V1\ProdutoController@colecao_index");
Route::get('produto/categoria/show/name/{nome}', "API\V1\ProdutoController@categoria_produto_nome");

Route::post('cliente/store', 'API\V1\ClienteController@store');


Route::get('slider/todos', "API\V1\SliderController@index");
Route::get('slider/unico/{id}', "API\V1\SliderController@show");

Route::group(['middleware' => 'auth:api', 'cors','prefix' => 'venda'], function () {
    Route::post('store', 'API\V1\VendaController@store');
    Route::post('remove-produto', 'API\V1\VendaController@remove_da_venda');
    Route::put('update', 'API\V1\VendaController@update');
    Route::delete('destroy/{uuid}', 'API\V1\VendaController@destroy');
    Route::get('show/{uuid}','API\V1\VendaController@show');
    Route::post('concluir/cliente/{cliente_uuid}', 'API\V1\VendaController@complete_cliente');
});

Route::group(['middleware' => 'auth:api', 'cors','prefix' => 'fornecedor'], function () {
    Route::post('store', "API\V1\FornecedorController@store");
    Route::get('show', "API\V1\FornecedorController@show");
    Route::post('update/{uuid}', "API\V1\FornecedorController@update");
});

Route::group(['middleware' => 'auth:api', 'cors', 'prefix' => 'produto'], function () {
    Route::post('store', "API\V1\ProdutoController@store");
    Route::post('desabilita/{uuid}', "API\V1\ProdutoController@desabilita");
    Route::post('foto/store', "API\V1\ProdutoController@store_foto");
    Route::post('store_update', "API\V1\ProdutoController@store_update_fornecedor");
    Route::delete('foto/delete', "API\V1\ProdutoController@destroy_foto");
    Route::get('show/administrativo', 'API\V1\ProdutoController@show_administrativo');
    Route::put('update', "API\V1\ProdutoController@update");
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

Route::group(['middleware' => 'auth:api','cors','prefix' => 'slider'], function () {
    Route::post('inserir', 'API\V1\SliderController@store');
    Route::put('atualizar', 'API\V1\SliderController@update');
    Route::put('deletar', 'API\V1\SliderController@destroy');
    Route::get('get_adm', 'API\V1\SliderController@index_adm');
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'API\V1\authController@login');
    Route::post('register', 'API\V1\authController@register');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'API\V1\authController@logout');
        Route::get('user', 'API\V1\authController@user');
        Route::put('user/update', 'API\V1\authController@user_update');
        Route::get('user/list', 'API\V1\authController@user_list');
        Route::post('ativar-conta', "API\V1\authController@ativar_conta");
        Route::get('show/user/{uuid}', "API\V1\authController@show_user");
        Route::delete('destroy/{uuid}', "API\V1\authController@destroy");
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

Route::group(['middleware' => 'auth:api', 'cors','prefix' => 'financeiro'], function () {

    Route::post('store', "API\V1\FinanceiroController@store");
    Route::put('update/{fluxo_financeiro_uuid}', "API\V1\FinanceiroController@update");
    Route::get('filter/{inicio}/{fim}', "API\V1\FinanceiroController@index");
    Route::get('lista', "API\V1\FinanceiroController@financeiro_list");

});
