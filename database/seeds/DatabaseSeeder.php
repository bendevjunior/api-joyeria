<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(sys_estado_br::class);
        $this->call(sys_cidade_br::class);
        $this->call(endereco_seed::class);
        $this->call(ProdutoCategorySeed::class);
        $this->call(ProdutoColecaoSeed::class);
        User::create([
            'nome'=> 'Augusto Furlan',
            'email'=> 'gulyfurlan@gmail.com',
            'password'=>bcrypt('123123'), 
            'role'=>1, 
            'cpf_cnpj'=>'428.338.578-61', 
            'data_nascimento'=>'1996-07-31', 
            'nome_mae'=> 'Estela',
            'nome_pai'=> 'Flavio', 
            'endereco_id' => 1,
            'status' => 1
        ]);
        User::create([
            'nome'=> 'Júnior Silva',
            'email'=> 'juniorsilvaasafe@gmail.com',
            'password'=>bcrypt('admin@9988'), 
            'role'=>1, 
            'cpf_cnpj'=>'057.666.091-40', 
            'data_nascimento'=>'1998-10-20', 
            'nome_mae'=> 'Eunice',
            'nome_pai'=> 'Benedito', 
            'endereco_id' => 1,
            'status' => 1
        ]);
        User::create([
            'nome'=> 'Joyeria',
            'email'=> 'adm@joyeria.com.br',
            'password'=>bcrypt('0711jbr'), 
            'role'=>1, 
            'cpf_cnpj'=>'057.666.091-40', 
            'data_nascimento'=>'1998-10-20', 
            'nome_mae'=> 'SEM',
            'nome_pai'=> 'SEM', 
            'endereco_id' => 1,
            'status' => 1
        ]);
        $this->call(FornecedorSeed::class);
        $this->call(ProdutoSeed::class);
        $this->call(ProdutoFornecedorSeed::class);
        $this->call(ProdutoFotoSeed::class);
        $this->call(ConsignadoSeed::class);
    }
}
