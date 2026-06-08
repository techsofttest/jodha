<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\HomePageSection;

class Category extends Model
{
    //
    protected $fillable = ['name', 'description', 'image', 'slug', 'meta_title', 'meta_description', 'meta_keywords'];

    protected static function booted()
    {
        static::saving(function ($category) {
            $slug = Str::slug($category->name);
            $originalSlug = $slug;
            $count = 1;
            while (static::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $category->slug = $slug;
        });

        static::saved(function () {
            HomePageSection::clearHomepageCache();
        });

        static::deleted(function () {
            HomePageSection::clearHomepageCache();
        });
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'subcat_cat_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'prod_cat_id');
    }
}
