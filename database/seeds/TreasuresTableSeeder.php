<?php

use Illuminate\Database\Seeder;

class TreasuresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('treasures')->insert([
            'id' => 1,
            'display' => 'Cofre',
            'name' => 'safe_box',
            'value' => 0.00,
            'store_id' => 1
        ]);
        DB::table('treasures')->insert([
            'id' => 2,
            'display' => 'Gaveta',
            'name' => 'cash_drawer',
            'value' => 0.00,
            'store_id' => 1
        ]);
        DB::table('treasures')->insert([
            'id' => 3,
            'display' => 'PagSeguro',
            'name' => 'pagseguro',
            'value' => 0.00,
            'store_id' => 1
        ]);
        
        DB::table('treasures')->insert([
            'id' => 4,
            'display' => 'Banco',
            'name' => 'bank',
            'value' => 0.00,
            'store_id' => 1
        ]);
    }
}