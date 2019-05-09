<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutoComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto_compras', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('produto_id')->unsigned();
            $table->integer('fornecedor_id')->unsigned();
            $table->string('descricao')->nullable();
            $table->integer('qnt')->default(0);
            $table->string('lote')->nullable();
            $table->decimal('valor_unitario', 11, 2)->nullable();
            $table->decimal('valor_total', 11, 2)->nullable();
            $table->decimal('peso_total', 11, 2)->nullable();
            $table->decimal('valor etiqueta', 11, 2)->nullable();
            $table->string('numero_nf')->nullable();
            $table->string('galvanica')->nullable();
            $table->string('banho')->nullable();
            $table->string('milisimagem_ouro')->nullable();
            $table->date('data_pagamento')->nullable();
            $table->date('data_fabricacao')->nullable();
            $table->date('data_entrega')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
            $table->foreign('produto_id')->references('id')->on('produtos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produto_compras');
    }
}
