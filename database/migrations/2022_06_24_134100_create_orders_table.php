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
            $table->unsignedDecimal('shipping', 12, 2);
            $table->unsignedDecimal('tax_amount', 12, 2);
            $table->unsignedTinyInteger('tax_percent');
            $table->unsignedDecimal('sub_total', 12, 2);
            $table->unsignedDecimal('total', 12, 2);
            $table->json('discount')->nullable();
            //$table->string('type')->nullable(); //cart // order_completed
            $table->json('user_data')->nullable();
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
