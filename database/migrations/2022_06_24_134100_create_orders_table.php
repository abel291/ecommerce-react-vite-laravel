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
			$table->string('code', 10);
			$table->unsignedInteger('quantity');
			$table->unsignedFloat('shipping');
			$table->unsignedFloat('tax_amount');
			$table->unsignedFloat('tax_percent');
			$table->unsignedFloat('sub_total');
			$table->unsignedFloat('total');
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
