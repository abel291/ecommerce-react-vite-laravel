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
            $table->string('slug')->index();
            $table->text('entry');
            $table->text('description')->nullable();

            $table->string('ref')->nullable();

            $table->string('img')->nullable();
            $table->string('thumb')->nullable();
            $table->unsignedSmallInteger('max_quantity');
            $table->decimal('old_price')->nullable();
            $table->unsignedTinyInteger('offer')->nullable();
            $table->decimal('price')->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('active')->default(true);

            $table->foreignId('parent_id')->nullable()->constrained('products')->nullOnDelete();
            $table->foreignId('color_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('skus', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('stock')->default(0);
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('size_id')->nullable()->constrained()->nullOnDelete();
            $table->index(['product_id', 'size_id']);
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
        Schema::dropIfExists('skus');
    }
}
