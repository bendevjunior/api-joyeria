<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarrinhoProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrinho_produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('carrinho_id')->unsigned();
            $table->integer('produto_id')->unsigned();
            $table->timestamps();

            $table->foreign('carrinho_id')->references('id')->on('carrinhos');
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
        Schema::dropIfExists('carrinho_produtos');
    }
}
