<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specifications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_slug')->nullable();            
            $table->foreignId('category_id')->index();
            $table->timestamps();
        });

        Schema::create('product_specification', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specification_id')->index();
            $table->foreignId('product_id')->index();
            $table->string('value');
            $table->string('value_slug')->nullable();
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
        Schema::dropIfExists('specifications');
        Schema::dropIfExists('product_specification');
    }
}
