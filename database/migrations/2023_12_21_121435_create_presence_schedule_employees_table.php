<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presence_schedule_employee', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employeeId');
            $table->unsignedBigInteger('dayId');
            $table->unsignedBigInteger('locationWorkId');

            $table->foreign('employeeId')->references('id')->on('users');
            $table->foreign('dayId')->references('id')->on('presence_list_day');
            $table->foreign('locationWorkId')->references('id')->on('presence_location_work');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presence_schedule_employee');
    }
};
