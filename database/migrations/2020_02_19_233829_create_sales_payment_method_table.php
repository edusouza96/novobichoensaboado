<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesPaymentMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_payment_method', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('value_received', 10, 2);
            $table->decimal('leftover', 10, 2);
            $table->integer('payment_method_id');
            $table->integer('plots');
            $table->integer('sale_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_payment_method');
    }
}
