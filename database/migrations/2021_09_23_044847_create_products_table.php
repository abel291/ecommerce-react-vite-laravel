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
            $table->string('slug')->unique()->index();
            $table->text('description_min')->nullable();
            $table->text('description_max')->nullable();
            $table->decimal('thumb')->nullable();
            $table->string('img')->nullable();
            $table->decimal('old_price')->nullable();
            $table->unsignedTinyInteger('offer')->nullable();
            $table->decimal('price')->default(0);
            $table->unsignedSmallInteger('max_quantity');
            $table->boolean('featured')->default(false);
            $table->boolean('active')->default(true);
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
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
