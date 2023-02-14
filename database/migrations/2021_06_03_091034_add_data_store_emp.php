<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataStoreEmp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_emps', function (Blueprint $table) {
            $table->string('employee_id')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->date('dob')->nullable();
            $table->date('joinning_date')->nullable();
            $table->string('payout')->nullable();
            $table->string('worktype')->nullable();
            $table->string('hours_per_week')->nullable();
            $table->text('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_emps', function (Blueprint $table) {
            $table->dropColumn(['employee_id','email','phone_number','dob','joinning_date','payout','worktype','hours_per_week','address']);
        });
    }
}
