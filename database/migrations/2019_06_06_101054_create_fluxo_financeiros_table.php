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
            $table->string('descricao');
            $table->date('data_vencimento');
            $table->decimal('valor', 11, 2)->nullable();

            $table->softDeletes();
            $table->timestamps();
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
