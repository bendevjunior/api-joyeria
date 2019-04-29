<?php

use Illuminate\Database\Seeder;
use App\Models\PivoProdutoFornecedor;

class ProdutoFornecedorSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        PivoProdutoFornecedor::create([
            'produto_id'=>1, 
            'fornecedor_id'=>1
        ]);

        PivoProdutoFornecedor::create([
            'produto_id'=>2, 
            'fornecedor_id'=>1
        ]);
    }
}
