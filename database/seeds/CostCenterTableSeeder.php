<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostCenterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cost_center')->insert(['id' => 1001, 'name' => 'Aporte Caixa Inicial', 'cost_center_category_id' => 1000]);
        DB::table('cost_center')->insert(['id' => 1002, 'name' => 'Aporte', 'cost_center_category_id' => 1000]);
        DB::table('cost_center')->insert(['id' => 1003, 'name' => 'Sangria', 'cost_center_category_id' => 1000]);
        DB::table('cost_center')->insert(['id' => 1004, 'name' => 'Estorno', 'cost_center_category_id' => 1000]);
    }
}
