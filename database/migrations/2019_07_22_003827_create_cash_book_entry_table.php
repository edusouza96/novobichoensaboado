<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashBookEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_book_moves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('value', 10, 2);
            $table->integer('cash_book_id');
            $table->integer('source_id');
            $table->enum('type', ['E', 'O']);
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
        Schema::dropIfExists('cash_book_moves');
    }
}
