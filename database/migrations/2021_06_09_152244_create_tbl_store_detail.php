<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblStoreDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_store_detail', function (Blueprint $table) {
            $table->id();
            $table->string('storename');
            $table->string('firstname');
            $table->string('Lastname');
            $table->string('Email');
            $table->string('Phone');
            $table->string('Address');
            $table->string('District');
            $table->string('Country');
            $table->string('Zipcode');
            $table->string('Plan');
            $table->string('Actual_plan');
            $table->string('plan_amount');
            $table->string('Contract_Start_Date');
            $table->string('Contact_end_date');
            $table->string('Payment terms');
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
        Schema::dropIfExists('tbl__store_detail');
    }
}
