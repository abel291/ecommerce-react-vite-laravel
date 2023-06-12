<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_products', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->unsignedDecimal('price', 12, 2)->nullable();
			$table->unsignedInteger('quantity_selected');
			$table->unsignedDecimal('price_quantity', 12, 2)->nullable();
			$table->json('data')->nullable();
			$table->string('type', 40); // CartEnum -> shopping-cart | wish-list

			$table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
			$table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
			$table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
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
		Schema::dropIfExists('order_products');
	}
}
