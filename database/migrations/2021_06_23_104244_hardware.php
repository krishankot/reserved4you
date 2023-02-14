<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Hardware extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_hardware', function (Blueprint $table) {
            $table->id();
            $table->string('store_id');
            $table->string('Service_name');
            $table->string('Service_plan');
            $table->string('plan_type');
            $table->string('Service_amount');
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
        Schema::dropIfExists('tbl_hardware');
    }
}
