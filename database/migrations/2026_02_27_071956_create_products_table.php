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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('prod_sku_code')->unique();

            $table->foreignId('prod_cat_id')
                ->constrained('categories')
                ->cascadeOnDelete();

            $table->foreignId('prod_subcat_id')
                ->constrained('subcategories')
                ->cascadeOnDelete();

            $table->foreignId('prod_col_id')
                ->constrained('collections')
                ->cascadeOnDelete();

            $table->string('prod_name')->index();

            $table->longText('prod_description')->nullable();
            $table->longText('prod_material')->nullable();
            $table->longText('prod_measurements')->nullable();

            $table->string('prod_image')->nullable();
            $table->string('prod_slug')->unique();

            $table->decimal('prod_price', 10, 2)->nullable();
            $table->string('prod_offer')->nullable();
            $table->decimal('prod_sale_price', 10, 2)->nullable();

            $table->integer('prod_stock')->default(0);

            $table->integer('prod_expected_delivery')->nullable();

            $table->boolean('prod_isactive')->default(true);

            $table->boolean('prod_trending')->default(true);
            $table->boolean('prod_hotdeal')->default(true);
            $table->boolean('prod_deal_of_day')->default(true);
            $table->boolean('prod_new_arrival')->default(true);

            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->index(['prod_cat_id', 'prod_subcat_id', 'prod_col_id',]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
