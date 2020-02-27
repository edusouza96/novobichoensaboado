<?php

use Illuminate\Database\Seeder;

class OwnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('owners')->insert([
            'name' => 'Eduardo da Silva Souza',
            'cpf' => '86175556020',
            'email' => 'eduardo_souza96@hotmail.com',
            'neighborhood_id' => 1,
            'address' => 'Rua Begônia 85',
            'phone1' => '981882850',
            'phone2' => '34928419',
        ]);
    }
}
