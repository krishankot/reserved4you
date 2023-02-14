<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSelesStaffDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_seles_staff_detail', function (Blueprint $table) {
            $table->id();
            $table->string('store_id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('Staff_id_no');
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
        Schema::dropIfExists('tbl__seles__staff__detail');
    }
}
