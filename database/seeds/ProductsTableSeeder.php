<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'barcode' => 'BE10101010',
            'name' => 'Biscoito',
            'valueSales' => '10',
            'valueBuy' => '5',
            'quantity' => '10',
        ]);
    }
}
