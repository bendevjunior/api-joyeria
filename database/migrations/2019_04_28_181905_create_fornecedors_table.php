<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFornecedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('endereco_id')->unsigned();
            $table->string('nome');
            $table->string('email')->nullable();
            $table->string('cpf_cnpj')->nullable();
            $table->string('nome_contato')->nullable();
            $table->string('tel1')->nullable();
            $table->string('tel2')->nullable();
            $table->string('website')->nullable();
            $table->text('obs')->nullable();
            $table->smallInteger('status')->default(1)->comment('0-desativado | 1- ativado');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('endereco_id')->references('id')->on('enderecos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fornecedores');
    }
}
