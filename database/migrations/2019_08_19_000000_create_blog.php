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
        Schema::create('blog', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blogCategoryId');
            $table->unsignedBigInteger('authorId');
            $table->text('title');
            $table->text('image');
            $table->longText('body');
            $table->timestamps();

            $table->foreign('blogCategoryId')->references('id')->on('blog_category');
            $table->foreign('authorId')->references('id')->on('users');

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
        Schema::dropIfExists('blog');
    }
};
