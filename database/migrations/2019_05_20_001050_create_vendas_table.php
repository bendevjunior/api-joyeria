<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            //$table->integer('produto_id')->unsigned();
            $table->integer('cliente_id')->unsigned();
            $table->integer('fluxo_financeiro_id')->nullable()->comment('se gerou cobranca colocar aqui');
            $table->integer('consignado_id')->unsigned()->nullable();
            //$table->integer('qnt')->nullable();
            $table->decimal('preco', 11, 2)->nullable();
            $table->decimal('preco_final', 11, 2)->nullable();
            $table->decimal('preco_do_desconto', 11, 2)->nullable();
            $table->decimal('preco_do_acrescimo', 11, 2)->nullable();
            //$table->date('data_pagamento')->nullable();
            $table->smallInteger('status')->default(0)->comment('0- em aberto | 1- finalizado');
            
            

            $table->timestamps();
            $table->softDeletes();
            //Colocar dados do boleto

            $table->foreign('cliente_id')->references('id')->on('users');
            //$table->foreign('produto_id')->references('id')->on('produtos');
            $table->foreign('consignado_id')->references('id')->on('consignados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendas');
    }
}
