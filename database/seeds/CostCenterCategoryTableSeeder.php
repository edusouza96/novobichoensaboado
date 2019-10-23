<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostCenterCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cost_center_category')->insert(['name' => 'Contas Fixas']);
        DB::table('cost_center_category')->insert(['name' => 'Departamento Pessoal']);
        DB::table('cost_center_category')->insert(['name' => 'Insumos']);
        DB::table('cost_center_category')->insert(['name' => 'Produtos']);
        DB::table('cost_center_category')->insert(['name' => 'Equipamentos']);
        DB::table('cost_center_category')->insert(['name' => 'Diversos']);
        DB::table('cost_center_category')->insert(['name' => 'Fornecedor']);
        DB::table('cost_center_category')->insert(['id' => 1000, 'name' => 'Sistema']);
    }
}
