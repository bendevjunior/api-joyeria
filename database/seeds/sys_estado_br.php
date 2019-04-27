<?php

use Illuminate\Database\Seeder;

class sys_estado_br extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('sys_estado_br')->insert(['id' => 1, 'nome' => 'Acre', 'abreviacao' => 'AC']);
        DB::table('sys_estado_br')->insert(['id' => 2, 'nome' => 'Alagoas', 'abreviacao' => 'AL']);
        DB::table('sys_estado_br')->insert(['id' => 3, 'nome' => 'Amapá', 'abreviacao' => 'AP']);
        DB::table('sys_estado_br')->insert(['id' => 4, 'nome' => 'Amazonas', 'abreviacao' => 'AM']);
        DB::table('sys_estado_br')->insert(['id' => 5, 'nome' => 'Bahia', 'abreviacao' => 'BA']);
        DB::table('sys_estado_br')->insert(['id' => 6, 'nome' => 'Ceará', 'abreviacao' => 'CE']);
        DB::table('sys_estado_br')->insert(['id' => 7, 'nome' => 'Distrito Federal', 'abreviacao' => 'DF']);
        DB::table('sys_estado_br')->insert(['id' => 8, 'nome' => 'Espírito Santo', 'abreviacao' => 'ES']);
        DB::table('sys_estado_br')->insert(['id' => 9, 'nome' => 'Goiás', 'abreviacao' => 'GO']);
        DB::table('sys_estado_br')->insert(['id' => 10, 'nome' => 'Maranhão', 'abreviacao' => 'MA']);
        DB::table('sys_estado_br')->insert(['id' => 11, 'nome' => 'Mato Grosso', 'abreviacao' => 'MT']);
        DB::table('sys_estado_br')->insert(['id' => 12, 'nome' => 'Mato Grosso do Sul', 'abreviacao' => 'MS']);
        DB::table('sys_estado_br')->insert(['id' => 13, 'nome' => 'Minas Gerais', 'abreviacao' => 'MG']);
        DB::table('sys_estado_br')->insert(['id' => 14, 'nome' => 'Pará', 'abreviacao' => 'PA']);
        DB::table('sys_estado_br')->insert(['id' => 15, 'nome' => 'Paraíba', 'abreviacao' => 'PB']);
        DB::table('sys_estado_br')->insert(['id' => 16, 'nome' => 'Paraná', 'abreviacao' => 'PR']);
        DB::table('sys_estado_br')->insert(['id' => 17, 'nome' => 'Pernambuco', 'abreviacao' => 'PE']);
        DB::table('sys_estado_br')->insert(['id' => 18, 'nome' => 'Piauí', 'abreviacao' => 'PI']);
        DB::table('sys_estado_br')->insert(['id' => 19, 'nome' => 'Rio de Janeiro', 'abreviacao' => 'RJ']);
        DB::table('sys_estado_br')->insert(['id' => 20, 'nome' => 'Rio Grande do Norte', 'abreviacao' => 'RN']);
        DB::table('sys_estado_br')->insert(['id' => 21, 'nome' => 'Rio Grande do Sul', 'abreviacao' => 'RS']);
        DB::table('sys_estado_br')->insert(['id' => 22, 'nome' => 'Rondônia', 'abreviacao' => 'RO']);
        DB::table('sys_estado_br')->insert(['id' => 23, 'nome' => 'Roraima', 'abreviacao' => 'RR']);
        DB::table('sys_estado_br')->insert(['id' => 24, 'nome' => 'Santa Catarina', 'abreviacao' => 'SC']);
        DB::table('sys_estado_br')->insert(['id' => 25, 'nome' => 'São Paulo', 'abreviacao' => 'SP']);
        DB::table('sys_estado_br')->insert(['id' => 26, 'nome' => 'Sergipe', 'abreviacao' => 'SE']);
        DB::table('sys_estado_br')->insert(['id' => 27, 'nome' => 'Tocantins', 'abreviacao' => 'TO']);
    }
}
