<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRebatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rebates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('value', 10, 0);
            $table->boolean('active')->default(1);
            /** Desconto em serviços de banho e tosa */
            $table->boolean('pet')->default(0);
            /** Desconto em serviços de Veterianaria */
            $table->boolean('vet')->default(0);
            /** Desconto em produtos da loja */
            $table->boolean('product')->default(0);
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
        Schema::dropIfExists('rebates');
    }
}
