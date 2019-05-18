<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutoColecaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto_colecaos', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('nome');
            $table->smallInteger('status')->default(1)->comment('0-desativado | 1- ativado');
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
        Schema::dropIfExists('produto_colecaos');
    }
}
