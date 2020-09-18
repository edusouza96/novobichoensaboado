<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTreasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('treasures')
            ->where('name', '=', 'safe_box')
            ->update(['source_id' => 1]);

        DB::table('treasures')
            ->where('name', '=', 'cash_drawer')
            ->update(['source_id' => 2]);

        DB::table('treasures')
            ->where('name', '=', 'pagseguro')
            ->update(['source_id' => 3]);

        DB::table('treasures')
            ->where('name', '=', 'bank')
            ->update(['source_id' => 4]);

        DB::table('treasures')
            ->where('name', '=', 'delivery_fee')
            ->update(['source_id' => 5]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('treasures')
            ->update(['source_id' => 5]);
    }
}
