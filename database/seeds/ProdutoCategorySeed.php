<?php

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProdutoCategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::create([
            'nome' => 'Categoria A'
        ]);
    }
}
