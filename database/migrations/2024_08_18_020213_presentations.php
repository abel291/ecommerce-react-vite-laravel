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
        Schema::create('presentations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedInteger('code')->unique();
            $table->boolean('default')->default(0);
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('color_attribute_id')->constrained()->cascadeOnDelete();
            $table->foreignId('size_attribute_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentations');
    }
};
