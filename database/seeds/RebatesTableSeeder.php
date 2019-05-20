<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RebatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rebates')->insert([
            'name' => 'Quarta maluca 20%',
            'value' => '20.00',
            'active' => 1,
            'pet' => 1,
            'vet' => 1
        ]);
    }
}
