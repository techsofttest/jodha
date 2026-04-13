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
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('color_code')->nullable();
            $table->timestamps();
        });

        $colors = [
            ['name' => 'Red', 'color_code' => '#FF0000'],
            ['name' => 'Blue', 'color_code' => '#0000FF'],
            ['name' => 'Green', 'color_code' => '#008000'],
            ['name' => 'Black', 'color_code' => '#000000'],
            ['name' => 'White', 'color_code' => '#FFFFFF'],
            ['name' => 'Yellow', 'color_code' => '#FFFF00'],
            ['name' => 'Orange', 'color_code' => '#FFA500'],
            ['name' => 'Pink', 'color_code' => '#FFC0CB'],
            ['name' => 'Purple', 'color_code' => '#800080'],
            ['name' => 'Brown', 'color_code' => '#A52A2A'],
            ['name' => 'Gray', 'color_code' => '#808080'],
            ['name' => 'Cyan', 'color_code' => '#00FFFF'],
            ['name' => 'Magenta', 'color_code' => '#FF00FF'],
            ['name' => 'Silver', 'color_code' => '#C0C0C0'],
            ['name' => 'Gold', 'color_code' => '#FFD700'],
            ['name' => 'Navy', 'color_code' => '#000080'],
            ['name' => 'Olive', 'color_code' => '#808000'],
            ['name' => 'Maroon', 'color_code' => '#800000'],
            ['name' => 'Teal', 'color_code' => '#008080'],
            ['name' => 'Lime', 'color_code' => '#00FF00'],
            ['name' => 'Aqua', 'color_code' => '#00FFFF'],
            ['name' => 'Beige', 'color_code' => '#F5F5DC'],
            ['name' => 'Ivory', 'color_code' => '#FFFFF0'],
            ['name' => 'Skin', 'color_code' => '#F3E5AB'],
            ['name' => 'Peach', 'color_code' => '#FFDAB9'],
            ['name' => 'Lavender', 'color_code' => '#E6E6FA'],
            ['name' => 'Turquoise', 'color_code' => '#40E0D0'],
            ['name' => 'Mustard', 'color_code' => '#FFDB58'],
        ];

        foreach ($colors as $color) {
            \Illuminate\Support\Facades\DB::table('colors')->insert(array_merge($color, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colors');
    }
};
