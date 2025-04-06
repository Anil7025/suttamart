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
        Schema::create('menu_parents', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id')->nullable();
			$table->string('menu_type')->nullable();
			$table->string('child_menu_type')->nullable();
			$table->integer('item_id')->nullable();
			$table->text('item_label')->nullable();
			$table->text('custom_url')->nullable();
			$table->string('target_window')->nullable();
			$table->integer('column')->nullable();
			$table->string('width_type')->nullable();
			$table->integer('width')->nullable();
			$table->integer('sort_order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_parents');
    }
};
