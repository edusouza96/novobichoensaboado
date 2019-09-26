<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BreedsTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(NeighborhoodsTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(DiariesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(OwnersTableSeeder::class);
        $this->call(RebatesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(TreasuresTableSeeder::class);

    }
}
