<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{

		Schema::create('attributes', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('slug')->index();
			$table->foreignId('product_id')->constrained()->cascadeOnDelete();
			$table->timestamps();
		});

		Schema::create('attribute_values', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('slug')->index();
			//$table->string('qunatity')->default(0);
			$table->boolean('in_stock')->default(0);
			$table->boolean('default')->default(0);
			$table->foreignId('product_id')->constrained()->cascadeOnDelete();
			$table->foreignId('attribute_id')->constrained()->cascadeOnDelete();
			$table->timestamps();
		});

		Schema::create('order_attributes', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('value');
			$table->foreignId('order_product_id')->constrained()->cascadeOnDelete();
			$table->foreignId('attribute_id')->constrained()->cascadeOnDelete();
			$table->foreignId('attribute_value_id')->constrained()->cascadeOnDelete();
			$table->timestamps();
		});

		Schema::create('skus', function (Blueprint $table) {
			$table->id();
			$table->string('sku')->comment('The actual alpha-numeric SKU code');
			$table->foreignId('product_id')->constrained()->cascadeOnDelete();
			$table->char('currency_code', 3);
			$table->unsignedInteger('unit_amount');
			$table->timestamps();
		});

		////
		// Schema::create('attributes', function (Blueprint $table) {
		// 	$table->id();
		// 	$table->string('name');
		// 	$table->string('slug');// 
		// 	$table->timestamps();
		// });

		// Schema::create('attribute_values', function (Blueprint $table) {
		// 	$table->id();
		// 	$table->string('name');
		// 	$table->string('slug');
		// 	$table->foreignId('attribute_id')->constrained()->cascadeOnDelete();
		// 	$table->timestamps();
		// });

		// Schema::create('product_attributes', function (Blueprint $table) {
		// 	$table->id();
		// 	$table->foreignId('product_id')->constrained()->cascadeOnDelete();
		// 	$table->foreignId('attribute_id')->constrained()->cascadeOnDelete();
		// 	$table->timestamps();
		// });

		// Schema::create('product_attribute_values', function (Blueprint $table) {
		// 	$table->id();
		// 	$table->boolean('is_default')->default(0);
		// 	$table->boolean('in_stock')->default(0);
		// 	$table->unsignedInteger('quantity')->default(0);
		// 	$table->foreignId('product_id')->constrained()->cascadeOnDelete();
		// 	$table->foreignId('product_attribute_id')->constrained()->cascadeOnDelete();
		// 	$table->foreignId('attribute_value_id')->constrained()->cascadeOnDelete();
		// 	$table->timestamps();
		// });

		// Schema::create('order_attributes', function (Blueprint $table) {
		// 	$table->id();
		// 	$table->foreignId('order_product_id')->constrained()->cascadeOnDelete();
		// 	$table->foreignId('product_attribute_id')->constrained()->cascadeOnDelete();
		// 	$table->foreignId('product_attribute_value_id')->constrained()->cascadeOnDelete();
		// 	$table->timestamps();
		// });

		// Schema::create('skus', function (Blueprint $table) {
		// 	$table->id();
		// 	$table->string('sku')->comment('The actual alpha-numeric SKU code');
		// 	$table->foreignId('product_id')->constrained()->cascadeOnDelete();
		// 	$table->char('currency_code', 3);
		// 	$table->unsignedInteger('unit_amount');
		// 	$table->timestamps();
		// });
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('attributes');
		Schema::dropIfExists('attribute_values');
		Schema::dropIfExists('product_attributes');
		Schema::dropIfExists('product_attribute_values');
		Schema::dropIfExists('order_attributes');
		Schema::dropIfExists('skus');
	}
};
