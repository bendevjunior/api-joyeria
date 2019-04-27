<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('estado_id')->unsigned();
            $table->integer('cidade_id')->unsigned();
            $table->string('rua', 100)->nullable();
            $table->integer('numero')->nullable();
            $table->string('complemento', 100)->nullable();
            $table->string('referencia', 100)->nullable();
            $table->string('bairro', 100)->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('latitude')->nullable();
            $table->string('logintitude')->nullable();
            $table->string('pais')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
}
