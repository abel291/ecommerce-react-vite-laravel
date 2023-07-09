<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('img');
            $table->string('thumb')->nullable();
            $table->string('alt')->nullable();
            $table->string('title')->nullable();
            $table->tinyInteger('sort')->nullable();
            $table->string('position')->nullable();
            $table->string('type')->nullable();
            $table->text('link')->nullable();
            $table->boolean('active')->default(1);
            $table->morphs('model');
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
        Schema::dropIfExists('images');
    }
}
