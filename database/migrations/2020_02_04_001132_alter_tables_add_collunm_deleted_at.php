<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablesAddCollunmDeletedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('breeds', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('clients', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('cost_center', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('cost_center_category', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('diaries', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('neighborhoods', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('outlays', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('owners', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('packages', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('rebates', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('services', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('users', function (Blueprint $table) { $table->softDeletes(); });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('breeds', function (Blueprint $table) { $table->dropColumn('deleted_at'); });
        Schema::table('clients', function (Blueprint $table) { $table->dropColumn('deleted_at'); });
        Schema::table('cost_center', function (Blueprint $table) { $table->dropColumn('deleted_at'); });
        Schema::table('cost_center_category', function (Blueprint $table) { $table->dropColumn('deleted_at'); });
        Schema::table('diaries', function (Blueprint $table) { $table->dropColumn('deleted_at'); });
        Schema::table('neighborhoods', function (Blueprint $table) { $table->dropColumn('deleted_at'); });
        Schema::table('outlays', function (Blueprint $table) { $table->dropColumn('deleted_at'); });
        Schema::table('owners', function (Blueprint $table) { $table->dropColumn('deleted_at'); });
        Schema::table('packages', function (Blueprint $table) { $table->dropColumn('deleted_at'); });
        Schema::table('rebates', function (Blueprint $table) { $table->dropColumn('deleted_at'); });
        Schema::table('services', function (Blueprint $table) { $table->dropColumn('deleted_at'); });
        Schema::table('users', function (Blueprint $table) { $table->dropColumn('deleted_at'); });
    }
}
