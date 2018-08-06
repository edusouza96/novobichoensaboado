<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_client');
            $table->integer('id_service');
            $table->boolean('fetch')->default(0);
            $table->decimal('value', 10, 2);
            $table->decimal('delivery_fee', 10, 2)->nullable();
            $table->decimal('gross', 10, 2);
            $table->timestamp('date_hour')->nullable();
            $table->integer('status')->default(0);
            $table->integer('id_package')->default(0);
            $table->string('companion',10)->default('false');
            $table->time('checkin_hour')->nullable();
            $table->time('checkout_hour')->nullable();
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
        Schema::dropIfExists('diaries');
    }
}