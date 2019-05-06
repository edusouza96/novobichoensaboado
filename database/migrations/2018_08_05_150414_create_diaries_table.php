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
            $table->integer('client_id');
            $table->boolean('fetch')->default(0);
            $table->integer('service_pet_id')->nullable();
            $table->decimal('service_pet_value', 10, 2)->default('0.00');
            $table->integer('service_vet_id')->nullable();
            $table->decimal('service_vet_value', 10, 2)->default('0.00');
            $table->decimal('delivery_fee', 10, 2)->nullable();
            $table->decimal('gross', 10, 2);
            $table->timestamp('date_hour')->nullable();
            $table->integer('status')->default(0);
            $table->integer('package_id')->default(0);
            $table->string('companion',10)->default('false');
            $table->time('checkin_hour')->nullable();
            $table->time('checkout_hour')->nullable();
            $table->string('observation')->nullable();
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
        Schema::dropIfExists('diaries');
    }
}