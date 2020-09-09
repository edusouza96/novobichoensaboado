<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSalesPaymentMethodTableAddColumnCashBookMoves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_payment_method', function (Blueprint $table) {
            $table->integer('cash_book_move_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cost_center', function (Blueprint $table) {
            $table->dropColumn('cash_book_move_id');
        });
    }
}
