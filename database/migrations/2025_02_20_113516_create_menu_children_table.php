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
        Schema::create('menu_children', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id')->nullable();
			$table->integer('menu_parent_id')->nullable();
			$table->integer('mega_menu_id')->nullable();
			$table->string('menu_type')->nullable();
			$table->integer('item_id')->nullable();
			$table->text('item_label')->nullable();
			$table->text('custom_url')->nullable();
			$table->string('target_window')->nullable();
			$table->integer('sort_order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_children');
    }
};
