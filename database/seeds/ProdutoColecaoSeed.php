<?php

use Illuminate\Database\Seeder;
use App\Models\ProdutoColecao;

class ProdutoColecaoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProdutoColecao::create([
            'nome' => 'Colecao A'
        ]);

        ProdutoColecao::create([
            'nome' => 'Colecao B'
        ]);
    }
}
