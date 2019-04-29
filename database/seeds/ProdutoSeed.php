<?php

use Illuminate\Database\Seeder;
use App\Models\Produto;

class ProdutoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        Produto::create([
            "nome"=> "Produto A - Obrigaório",
            "descricao"=> "Descricao", 
            "qnt"=> 10,
            "qnt_min"=>2, 
            "lote"=>"LOTE", 
            "valor_bruto"=>"10.00", 
            "valor_banho"=>"2.00",
            "valor_venda"=>"20.00", 
            "peso"=>"10.00"
        ]);

        Produto::create([
            "nome"=> "Produto B - Obrigaório",
            "descricao"=> "Descricao", 
            "qnt"=> 10,
            "qnt_min"=>2, 
            "lote"=>"LOTE", 
            "valor_bruto"=>"10.00", 
            "valor_banho"=>"2.00",
            "valor_venda"=>"20.00", 
            "peso"=>"10.00"
        ]);

    }
}
