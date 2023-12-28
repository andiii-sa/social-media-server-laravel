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
        Schema::table('presence_employee', function (Blueprint $table) {
            $table->dateTime('clockIn')->nullable()->change();
            $table->dateTime('clockOut')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presence_employee', function (Blueprint $table) {
            $table->time('clockIn')->nullable()->change();
            $table->time('clockOut')->nullable()->change();
        });
    }
};
