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
        Schema::create('stock_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('quantity');
            $table->unsignedMediumInteger('cost');
            $table->text('note')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); //responsable
            $table->foreignId('sku_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id();
            $table->text('note');
            $table->unsignedMediumInteger('quantity');
            $table->string('type'); // adicción - sustracción
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); //responsable
            $table->foreignId('sku_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_entries');
        Schema::dropIfExists('stock_adjustments');
    }
};
