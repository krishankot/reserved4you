<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_temps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('store_id')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('subcategory_id')->nullable();
            $table->bigInteger('service_id')->nullable();
            $table->string('service_name')->nullable();
            $table->bigInteger('variant_id')->nullable();
            $table->string('price')->nullable();
            $table->bigInteger('store_emp_id')->nullable();
            $table->date('appo_date')->nullable();
            $table->time('appo_time')->nullable();
            $table->time('app_end_time')->nullable();
            $table->enum('status',['paid','unpaid','failed'])->default('unpaid');
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
        Schema::dropIfExists('booking_temps');
    }
}
