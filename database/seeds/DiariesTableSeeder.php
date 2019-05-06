<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('diaries')->insert([
            'client_id' => 1,
            'fetch' => 1,
            'service_pet_id' => 1,
            'service_pet_value' => '10.00',
            'delivery_fee' => '5.00',
            'gross' => '15.00',
            'date_hour' => '2018-08-09 09:00:00',
            'status' => 1,
            'package_id' => 0,
            'companion' => false,
            'store_id' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
