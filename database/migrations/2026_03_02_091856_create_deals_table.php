<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('deal_product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('deal_product_size_id')
                ->nullable()
                ->constrained('product_sizes')
                ->nullOnDelete();

            $table->decimal('deal_price', 10, 2);

            $table->string('deal_label');

            $table->date('deal_date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
