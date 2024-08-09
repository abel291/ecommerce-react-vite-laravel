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

        Schema::create('skus', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('The actual alpha-numeric SKU code');
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('quantity')->default(0);
            $table->timestamps();
        });

        Schema::create('attribute_value_sku', function (Blueprint $table) {
            $table->foreignId('attribute_value_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('sku_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('attribute_values');
        Schema::dropIfExists('skus');
        Schema::dropIfExists('attribute_value_sku');
    }
};
