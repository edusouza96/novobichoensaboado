<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertCostCenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('cost_center')->insert([
            'id' => 2000,
            'name' => 'Pagamento/Adiantamento de Funcionário',
            'cost_center_category_id' => 2,
            'fixed' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('cost_center')->id('votes', '=', 2000)->delete();
    }
}
