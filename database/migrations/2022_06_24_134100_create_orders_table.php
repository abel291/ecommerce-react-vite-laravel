<?php

use App\Enums\OrderStatuEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatus;
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
            $table->string('status', 20)->default(OrderStatusEnum::SUCCESSFUL->value);
            $table->unsignedInteger('quantity');
            $table->decimal('sub_total', 12, 2);
            $table->decimal('tax_value');
            $table->unsignedTinyInteger('tax_rate');
            $table->decimal('shipping', 12, 2)->nullable();
            $table->decimal('total', 12, 2);
            $table->json('discount')->nullable();
            $table->json('data')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('discount_code_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('refund_at')->nullable();
            $table->timestamps();
        });

        Schema::create('orderProducts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ref');
            $table->string('thumb');
            $table->string('color');
            $table->string('size')->nullable();
            $table->decimal('old_price')->nullable();
            $table->unsignedTinyInteger('offer')->nullable();
            $table->decimal('price')->default(0);
            $table->unsignedInteger('quantity');
            $table->decimal('total', 12, 2)->nullable();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('sku_id')->nullable()->constrained()->nullOnDelete();
            $table->json('data')->nullable();
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
        Schema::dropIfExists('orderProducts');
    }
}
