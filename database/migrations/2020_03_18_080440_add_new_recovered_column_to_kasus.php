<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewRecoveredColumnToKasus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kasus', function (Blueprint $table) {
            $table->integer('new_recovered')->after('total_recovered');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kasus', function (Blueprint $table) {
            $table->dropColumn('new_recovered');
        });
    }
}
