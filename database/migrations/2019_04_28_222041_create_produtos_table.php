<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('categoria_id')->unsigned();
            $table->integer('colecao_id')->unsigned();
            $table->string('nome');
            $table->string('descricao');
            $table->string('codigo_de_barras')->nullable();
            $table->string('numero_codigo_de_barras')->nullable();
            $table->integer('qnt')->default(0);
            $table->integer('qnt_min')->default(0);
            $table->string('lote');
            $table->decimal('valor_bruto', 11, 2)->nullable();
            $table->decimal('valor_banho', 11, 2)->nullable();
            $table->decimal('valor_venda', 11, 2)->nullable();
            $table->decimal('peso', 11, 2)->nullable();
            $table->longText('primeira_imagem')->nullable();
            $table->smallInteger('status')->default(1)->comment('0-desativado | 1- ativado');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('categoria_id')->references('id')->on('product_categories');
            $table->foreign('colecao_id')->references('id')->on('produto_colecaos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
