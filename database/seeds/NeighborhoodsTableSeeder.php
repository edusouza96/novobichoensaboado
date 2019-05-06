<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NeighborhoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('neighborhoods')->insert([
            'name' => 'Sitio São José',
            'value' => '10.00'
        ]);
    }
}
