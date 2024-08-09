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
        Schema::create('attributes', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('attribute_values', static function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->foreignId('attribute_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('presentations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('The actual alpha-numeric SKU code');
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('stock');
            $table->string('value')->nullable();
            $table->timestamps();
        });

        Schema::create('attribute_value_presentation', function (Blueprint $table) {
            $table->foreignId('attribute_value_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('presentation_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('attribute_values');
        Schema::dropIfExists('presentations');
        Schema::dropIfExists('attribute_value_presentation');
    }
};
