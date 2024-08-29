<?php

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
            $table->string('status', 20)->default(PaymentStatus::SUCCESSFUL->value);
            $table->unsignedInteger('quantity');
            $table->decimal('sub_total', 12, 2);
            $table->json('discount', 12, 2)->nullable();
            $table->decimal('tax_value');
            $table->unsignedTinyInteger('tax_rate');
            $table->decimal('shipping', 12, 2)->nullable();
            $table->decimal('total', 12, 2);
            $table->json('data')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('discount_code_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('refund_at')->nullable();
            $table->timestamps();
        });

        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('old_price')->nullable();
            $table->unsignedTinyInteger('offer')->nullable();
            $table->decimal('price')->default(0);
            $table->unsignedInteger('quantity');
            $table->decimal('total', 12, 2)->nullable();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('presentation_id')->nullable()->constrained()->nullOnDelete();

            $table->json('data');
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
        Schema::dropIfExists('order_products');
    }
}
