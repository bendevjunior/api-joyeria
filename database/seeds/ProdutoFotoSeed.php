<?php

use Illuminate\Database\Seeder;
use App\Models\ProdutoFoto;

class ProdutoFotoSeed extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProdutoFoto::create(['produto_id'=>1, 'url'=>'urlA']);
        ProdutoFoto::create(['produto_id'=>1, 'url'=>'urlB']);
        ProdutoFoto::create(['produto_id'=>1, 'url'=>'urlC']);
    }
}
