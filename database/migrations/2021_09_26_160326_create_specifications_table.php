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
			$table->string('slug')->nullable();
			$table->string('value')->nullable();
			$table->boolean('active')->default(1);
			$table->foreignId('product_id')->constrained()->cascadeOnDelete();
			$table->timestamps();
		});

		// Schema::create('specifications', function (Blueprint $table) {
		// 	$table->id();
		// 	$table->string('name');
		// 	$table->string('slug')->nullable();
		// 	$table->foreignId('category_id')->constrained()->nullOnDelete();
		// 	$table->timestamps();
		// });

		// Schema::create('product_specification', function (Blueprint $table) {
		// 	$table->foreignId('specification_id')->constrained()->cascadeOnDelete();
		// 	$table->foreignId('product_id')->constrained()->cascadeOnDelete();
		// 	$table->string('value');
		// 	$table->timestamps();
		// });
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
