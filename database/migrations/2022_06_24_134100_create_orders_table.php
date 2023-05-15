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
			$table->unsignedDecimal('shipping', 12, 2);
			$table->unsignedDecimal('tax_amount', 12, 2);
			$table->unsignedDecimal('tax_percent', 12, 2);
			$table->unsignedDecimal('sub_total', 12, 2);
			$table->unsignedDecimal('total', 12, 2);
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
