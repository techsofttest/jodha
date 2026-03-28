<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('label')->nullable(); // optional category/tag label
            $table->date('date')->nullable(); // publish date

            $table->longText('content');

            $table->string('image');

            $table->string('slug')->unique(); // important for SEO

             $table->string('meta_title')->nullable();
              $table->string('meta_description')->nullable();
               $table->string('meta_keywords')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};