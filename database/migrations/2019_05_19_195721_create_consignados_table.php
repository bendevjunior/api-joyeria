<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsignadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignados', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('produto_id')->unsigned();
            $table->integer('cliente_id')->unsigned();
            $table->integer('qnt');
            $table->integer('qnt_vendido')->nullable();
            $table->date('data_devolucao')->nullable();
            $table->smallInteger('status')->default(0)->comment('0- em aberto | 1- finalizado');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cliente_id')->references('id')->on('users');
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
        Schema::dropIfExists('consignados');
    }
}
