<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20);
            $table->unsignedInteger('quantity');
            $table->unsignedDecimal('sub_total', 12, 2);
            $table->json('discount', 12, 2)->nullable();
            $table->unsignedFloat('tax_value');
            $table->unsignedTinyInteger('tax_rate');
            $table->unsignedDecimal('shipping', 12, 2)->nullable();
            $table->unsignedDecimal('total', 12, 2);
            $table->json('data')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('discount_code_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('refund_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
