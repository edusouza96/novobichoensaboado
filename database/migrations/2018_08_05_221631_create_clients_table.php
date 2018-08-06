<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_breed');
            $table->integer('id_neighborhood')->nullable();
            $table->string('owner', 255);
            $table->integer('id_owner')->nullable();
            $table->string('name', 255);
            $table->string('address', 255)->nullable();
            $table->bigInteger('phone1')->nullable();
            $table->bigInteger('phone2')->nullable();
            $table->string('email',255)->nullable();
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
        Schema::dropIfExists('clients');
    }
}
