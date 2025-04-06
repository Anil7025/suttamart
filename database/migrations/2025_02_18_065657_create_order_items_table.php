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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
			$table->integer('order_id')->nullable();
			$table->integer('customer_id')->nullable();
			$table->integer('seller_id')->nullable();
			$table->integer('product_id')->nullable();
			$table->string('variation_size', 100)->nullable();
			$table->string('variation_color', 100)->nullable();
			$table->integer('quantity')->nullable();
			$table->double('price', 12, 3)->nullable();
			$table->double('total_price', 12, 3)->nullable();
			$table->double('tax', 12, 3)->nullable();
			$table->double('discount', 12, 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
