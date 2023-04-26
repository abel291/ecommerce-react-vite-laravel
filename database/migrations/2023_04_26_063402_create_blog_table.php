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
		Schema::create('blog', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->string('slug');
			$table->string('meta_title');
			$table->string('meta_desc');
			$table->text('entry');
			$table->text('desc');
			$table->boolean('active')->default(1);
			$table->string('img');
			$table->timestamps();
		});

		Schema::create('blog_category', function (Blueprint $table) {
			$table->foreignId('blog_id')->constrained()->cascadeOnDelete();
			$table->foreignId('category_id')->constrained()->cascadeOnDelete();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('blog');
		Schema::dropIfExists('blog_category');
	}
};
