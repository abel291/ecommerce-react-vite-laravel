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
		Schema::disableForeignKeyConstraints();
		Schema::create('products', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('slug')->unique()->index();
			$table->text('description_min');
			$table->text('description_max');
			$table->string('img');
			$table->unsignedFloat('price')->default(0);
			$table->unsignedTinyInteger('offer')->nullable();
			$table->unsignedFloat('price_offer')->nullable();
			$table->unsignedInteger('max_quantity');
			$table->unsignedInteger('stock');
			$table->boolean('featured')->default(false);
			$table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
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
