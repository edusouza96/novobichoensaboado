<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treasures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('cash_drawer', 10, 2)->nullable();
            $table->decimal('safe_box', 10, 2)->nullable();
            $table->decimal('pagseguro', 10, 2)->nullable();
            $table->decimal('bank', 10, 2)->nullable();
            $table->integer('store_id');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('treasures');
    }
}
