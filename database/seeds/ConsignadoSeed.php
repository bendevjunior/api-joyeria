<?php

use Illuminate\Database\Seeder;
use App\Models\Consignado;

class ConsignadoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Consignado::create([
            'produto_id' => 1,
            'cliente_id' => 2,
            'qnt' => 10
        ]);

        Consignado::create([
            'produto_id' => 2,
            'cliente_id' => 2,
            'qnt' => 10
        ]);
    }
}
