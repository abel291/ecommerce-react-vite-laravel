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
			$table->string('type');
			$table->string('name')->nullable();
			$table->string('slug')->nullable();
			$table->text('value');
			$table->boolean('active')->default(1);
			$table->foreignId('product_id')->constrained()->cascadeOnDelete();
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
		Schema::dropIfExists('specifications');
	}
}
