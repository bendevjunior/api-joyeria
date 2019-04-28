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
            $table->string('nome');
            $table->string('descricao');
            $table->string('codigo_de_barras');
            $table->integer('qnt')->default(0);
            $table->integer('qnt_min')->default(0);
            $table->string('lote');
            $table->decimal('valore_bruto', 11, 2)->nullable();
            $table->decimal('valor_banho', 11, 2)->nullable();
            $table->decimal('valor_venda', 11, 2)->nullable();
            $table->decimal('peso', 11, 2)->nullable();
            $table->smallInteger('status')->default(0)->comment('0-desativado | 1- ativado');
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
        Schema::dropIfExists('produtos');
    }
}
