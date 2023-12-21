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
        Schema::create('presence_location_work', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->time('clockIn');
            $table->time('clockOut');
            $table->boolean('isRequiredLocation')->default(false)->nullable();
            $table->boolean('isRequiredPhoto')->default(false)->nullable();
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
        Schema::dropIfExists('presence_location_work');
    }
};
