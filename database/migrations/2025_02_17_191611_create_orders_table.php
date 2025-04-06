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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
			$table->string('order_no', 100)->nullable();
			$table->string('transaction_no', 100)->nullable();
			$table->integer('customer_id')->nullable();
			$table->integer('seller_id')->nullable();
			$table->integer('payment_method_id')->nullable();
			$table->integer('payment_status_id')->nullable();
			$table->integer('order_status_id')->nullable();
			$table->integer('total_qty')->nullable();
			$table->double('total_price', 12, 3)->nullable();
			$table->double('discount', 12, 3)->nullable();
			$table->double('tax', 12, 3)->nullable();
			$table->double('subtotal', 12, 3)->nullable();
			$table->double('total_amount', 12, 3)->nullable();
			$table->text('shipping_title')->nullable();
			$table->double('shipping_fee', 12, 3)->nullable();
			$table->string('name')->nullable();
			$table->string('email')->nullable();
			$table->string('phone')->nullable();
			$table->string('country')->nullable();
			$table->string('state')->nullable();
			$table->string('pincode')->nullable();
			$table->string('city')->nullable();
			$table->text('address')->nullable();
			$table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
