<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function (Blueprint $table) {
			$table->id();
			$table->string('code', 20);
			$table->unsignedInteger('quantity');
			$table->unsignedDecimal('shipping');
			$table->unsignedDecimal('tax_amount');
			$table->unsignedDecimal('tax_percent');
			$table->unsignedDecimal('sub_total');
			$table->unsignedDecimal('total');
			$table->json('user_json');
			$table->string('status');
			$table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
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
		Schema::dropIfExists('orders');
	}
}
