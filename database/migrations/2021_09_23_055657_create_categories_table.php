<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('slug')->unique()->index();
			$table->string('banner')->nullable();
			$table->string('img')->nullable();
			$table->string('entry')->nullable();
			$table->boolean('active')->default(true);
			$table->string('type')->index()->default('product'); //product , blog
			$table->json('specifications')->nullable();
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
		Schema::dropIfExists('categories');
	}
}
