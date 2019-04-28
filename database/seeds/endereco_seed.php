<?php

use Illuminate\Database\Seeder;
use App\Models\Endereco;

class endereco_seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Endereco::create([
            'estado_id' => 25, 
            'cidade_id'=>5142, 
            'rua'=>'Tenete Tomaz Nunes', 
            'numero'=>'126', 
            'complemento'=>null, 
            'referencia'=>null, 
            'bairro'=>'Nova Piracicaba', 
            'cep'=> '13405175', 
            'latitude'=>null, 
            'logintitude'=>null, 
            'pais'=>'Brasil'   
        ]);

        Endereco::create([
            'estado_id' => 25, 
            'cidade_id'=>5142, 
            'rua'=>'Tenete Tomaz Nunes', 
            'numero'=>'126', 
            'complemento'=>null, 
            'referencia'=>null, 
            'bairro'=>'Nova Piracicaba', 
            'cep'=> '13405175', 
            'latitude'=>null, 
            'logintitude'=>null, 
            'pais'=>'Brasil'   
        ]);
    }
}
