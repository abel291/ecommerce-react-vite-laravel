<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingCartTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shopping_cart', function (Blueprint $table) {
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->foreignId('product_id')->constrained()->cascadeOnDelete();
			$table->unsignedMediumInteger('quantity');
			$table->unsignedFloat('total_price_quantity');
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
		Schema::dropIfExists('shopping_cart');
	}
}
