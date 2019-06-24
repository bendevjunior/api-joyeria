<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutoVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto_vendas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('venda_id')->unsigned();
            $table->integer('cliente_id')->unsigned();
            $table->integer('qnt');
            $table->decimal('valor_desconto', 11, 2)->nullable();
            $table->decimal('valor_acrescimo', 11, 2)->nullable();
            $table->decimal('valor', 11, 2)->nullable();

            $table->foreign('venda_id')->references('id')->on('vendas');
            $table->foreign('cliente_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produto_vendas');
    }
}
