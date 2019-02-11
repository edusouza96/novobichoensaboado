<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            'name' => 'Bidu',
            'breed_id' => 1,
            'neighborhood_id' => 1,
            'owner_id' => 1,
            'owner_name' => 'Eduardo ',
            'address' => 'Rua Begônia 85',
            'phone1' => '981882850',
            'phone2' => '34928419',
            'email' => 'eduardo_souza96@hotmail.com',
        ]);
    }
}
