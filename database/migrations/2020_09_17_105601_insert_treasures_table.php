<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertTreasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('treasures')->insert([
            'name' => 'delivery_fee',
            'display' => 'Máquina da Busca',
            'value' => 0,
            'store_id' => 1,
            'card_machine' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('treasures')
            ->where('name', '=', 'delivery_fee')
            ->where('store_id', '=', '1')
            ->delete();
    }
}
