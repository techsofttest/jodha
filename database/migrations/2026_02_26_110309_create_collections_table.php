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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('col_cat_id')
                ->constrained('categories')
                ->cascadeOnDelete();

            $table->foreignId('col_subcat_id')
                ->constrained('subcategories')
                ->cascadeOnDelete();

            $table->string('col_name')->index();
            $table->longText('col_description')->nullable();
            $table->string('col_image')->nullable();
            $table->string('col_slug')->unique();

            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
