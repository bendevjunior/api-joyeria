<?php

use Illuminate\Database\Seeder;
use App\Models\Fornecedor;

class FornecedorSeed extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Fornecedor::create([
            'endereco_id'=>2,
            'nome'=> 'Fornecedor A', 
            'email'=> 'fornecedor@fornecedor.com', 
            'cpf_cnpj'=>'12345', 
            'nome_contato' => 'Nome fornecedor',
            'tel1'=>'1122334455',
            'tel2'=>'19997797781', 
            'website'=>'fornecedor.com.br', 
            'obs'=>'OBS', 
            'status'=>1
        ]);
    }
}
