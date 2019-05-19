<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('endereco_id')->unsigned();
            $table->string('nome');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('cpf_cnpj')->nullable();
            $table->date('data_nascimento');
            $table->string('nome_mae')->nullable();
            $table->string('nome_pai')->nullable();
            $table->string('api_token')->nullable();
            $table->string('tel1')->nullable();
            $table->string('tel2')->nullable();
            $table->text('obs')->nullable();
            $table->string('status_spc')->nullable();
            $table->integer('role')->default(3)->comment('1-admin | 2-revendedor | 3 - usuario do e-comerce');
            $table->smallInteger('status')->default(0)->comment('0-aguardando aprovacao | 1- ativado | 2- reprovado');
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
        Schema::dropIfExists('users');
    }
}
