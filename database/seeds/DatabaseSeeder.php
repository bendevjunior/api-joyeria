<?php

use Illuminate\Database\Seeder;

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
        //$this->call(UserSeeder::class);
    }
}
