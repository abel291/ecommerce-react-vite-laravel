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
			//$table->foreignId('product_id')->constrained()->cascadeOnDelete();
			$table->string('name');
			$table->string('slug');
			$table->timestamps();
		});

		Schema::create('attribute_values', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('slug');
			//$table->boolean('active')->default(1);
			$table->boolean('in_stock')->default(1);
			$table->foreignId('attribute_id')->constrained()->cascadeOnDelete();
			$table->timestamps();
		});

		Schema::create('attribute_product', function (Blueprint $table) {
			$table->id();
			$table->foreignId('product_id')->constrained()->cascadeOnDelete();
			$table->foreignId('attribute_id')->constrained()->cascadeOnDelete();
			$table->foreignId('attribute_value_id')->constrained()->cascadeOnDelete();
			$table->foreignId('sku_id')->nullable()->constrained()->cascadeOnDelete()->comment('unused column');
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
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('attributes');
		Schema::dropIfExists('attribute_values');
		Schema::dropIfExists('attribute_product');
		Schema::dropIfExists('skus');
	}
};
