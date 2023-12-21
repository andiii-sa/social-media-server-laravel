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
        Schema::create('presence_employee', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employeeId');
            $table->unsignedBigInteger('dayId');
            $table->string('dayName');
            $table->time('clockIn')->nullable();
            $table->time('clockOut')->nullable();
            $table->text('image')->nullable();
            $table->text('longitude')->nullable();
            $table->text('latitude')->nullable();
            $table->timestamps();

            $table->foreign('employeeId')->references('id')->on('users');
            $table->foreign('dayId')->references('id')->on('presence_list_day');
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
        Schema::dropIfExists('presence_employee');
    }
};
