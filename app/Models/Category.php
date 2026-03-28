<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    //
    protected $fillable = ['name', 'description', 'image', 'slug', 'meta_title', 'meta_description', 'meta_keywords'];

    protected static function booted()
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
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
