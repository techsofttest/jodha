<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Material extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'order',
    ];

    protected static function booted()
    {
        static::saving(function ($material) {
            if (! $material->slug && $material->name) {
                $slug = Str::slug($material->name);
                $originalSlug = $slug;
                $count = 1;

                while (static::where('slug', $slug)->where('id', '!=', $material->id)->exists()) {
                    $slug = $originalSlug . '-' . $count++;
                }

                $material->slug = $slug;
            }
        });
    }
}
