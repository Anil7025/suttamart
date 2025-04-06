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
        Schema::create('Shops', function (Blueprint $table) {
            $table->id();
			$table->string('name')->nullable();
            $table->string('email')->nullable();
			$table->text('mobile')->nullable();
			$table->string('shop_logo')->nullable();
			$table->string('address')->nullable();
            $table->integer('is_publish')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Shops');
    }
};
