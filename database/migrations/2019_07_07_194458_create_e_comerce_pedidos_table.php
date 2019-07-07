<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEComercePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_comerce_pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('venda_id')->unsigned();
            $table->integer('cliente_id')->unsigned();
            $table->integer('status')->default(0)->comment('');
            $table->string('metodo_correio')->nullable();
            $table->date('data_envio')->nullable();
            $table->string('codigo_correio')->nullable();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('e_comerce_pedidos');
    }
}
