<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFluxoFinanceirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fluxo_financeiros', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('cliente_id')->unsigned();
            $table->integer('venda_id')->unsigned();
            $table->string('descricao');
            $table->date('data_vencimento');
            $table->decimal('valor_da_parcela', 11, 2)->nullable();
            $table->decimal('valor_total_venda', 11, 2)->nullable();
            $table->integer('parcela_atual')->default(1);
            $table->integer('total_parcelas')->default(1);

            $table->string('bf_code')->nullable()->comment('codigo do boletofacil');
            $table->string('bf_reference')->nullable()->comment('reference do boletofacil');
            $table->string('bf_link')->nullable()->comment('link do boletofacil');
            $table->string('bf_barcode')->nullable()->comment('link do boletofacil');

            $table->smallInteger('status')->default(0)->comment('0- aberto 1-concluido');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('users');
            $table->foreign('venda_id')->references('id')->on('vendas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fluxo_financeiros');
    }
}
