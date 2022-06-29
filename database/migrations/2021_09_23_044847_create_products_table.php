<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description_min');
            $table->text('description_max');
            $table->integer('availables');
            $table->float('price_default');
            $table->tinyInteger('offer')->nullable();
            $table->float('price')->default(0);
            $table->string('img');
            $table->boolean('featured')->default(false);            
            $table->foreignId('brand_id')->index();
            $table->foreignId('category_id')->index();
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
        Schema::dropIfExists('products');
    }
}
