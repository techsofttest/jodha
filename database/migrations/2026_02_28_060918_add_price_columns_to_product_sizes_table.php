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
        Schema::table('product_sizes', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->after('stock');
            $table->integer('offer')->nullable()->after('price');
            $table->decimal('offer_price', 10, 2)->nullable()->after('offer');
        });
    }

    public function down(): void
    {
        Schema::table('product_sizes', function (Blueprint $table) {
            $table->dropColumn([
                'price',
                'offer',
                'offer_price',
            ]);
        });
    }
};
