<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumnsSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('leftover');
            $table->dropColumn('payment_method_id');
            $table->dropColumn('plots');
            $table->dropColumn('value_received');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('value_received', 10, 2)->nullable();
            $table->decimal('leftover', 10, 2)->nullable();
            $table->integer('payment_method_id')->nullable();
            $table->integer('plots')->nullable();
        });
    }
}
