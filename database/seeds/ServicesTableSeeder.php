<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            'name' => 'Banho+Tosa',
            'value' => '50.00',
            'breed_id' => 1,
            'package_type_id' => 1
        ]);
    }
}
