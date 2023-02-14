<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColoumnTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temp_service_stores', function (Blueprint $table) {
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->bigInteger('employee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temp_service_stores', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('time');
            $table->dropColumn('employee');
        });
    }
}
