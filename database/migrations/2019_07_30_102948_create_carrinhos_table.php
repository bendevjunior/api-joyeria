<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarrinhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrinhos', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('venda_id')->unsigned()->nullable();
            $table->integer('cliente_id')->unsigned();
            $table->decimal('valor', 11, 2)->nullable();
            $table->integer('status')->default(0)->comment('0-aberto | 1- fechado');
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
        Schema::dropIfExists('carrinhos');
    }
}
