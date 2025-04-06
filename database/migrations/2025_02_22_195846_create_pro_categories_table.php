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
        Schema::create('pro_categories', function (Blueprint $table) {
            $table->id();
			$table->string('name')->nullable();
			$table->string('slug')->unique();
			$table->text('image')->nullable();
            $table->text('sortdescription')->nullable();
            $table->text('description')->nullable();
			$table->text('subheader_image')->nullable();
			$table->integer('parent_id')->nullable();
			$table->integer('is_subheader')->nullable();
			$table->integer('is_publish')->nullable();
			$table->text('og_title')->nullable();
			$table->text('og_description')->nullable();
			$table->text('og_keywords')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pro_categories');
    }
};
