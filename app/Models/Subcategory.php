<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\HomePageSection;

class Subcategory extends Model
{
    //
    protected $fillable = ['subcat_cat_id', 'subcat_name', 'subcat_description', 'subcat_image', 'subcat_slug', 'meta_title', 'meta_description', 'meta_keywords'];

    public function getNameAttribute()
    {
        return $this->subcat_name;
    }

    public function getSlugAttribute()
    {
        return $this->subcat_slug;
    }

    public function getImageAttribute()
    {
        return $this->subcat_image;
    }

    public function getDescriptionAttribute()
    {
        return $this->subcat_description;
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'prod_subcat_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'subcat_cat_id');
    }

    public function collections()
    {
        return $this->hasMany(Collection::class, 'col_subcat_id')->orderBy('col_order', 'asc');
    }

    protected static function booted()
    {
        static::saving(function ($subcategory) {
            $slug = Str::slug($subcategory->subcat_name);
            $originalSlug = $slug;
            $count = 1;
            while (static::where('subcat_slug', $slug)->where('id', '!=', $subcategory->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $subcategory->subcat_slug = $slug;
        });

        static::saved(function () {
            HomePageSection::clearHomepageCache();
        });

        static::deleted(function () {
            HomePageSection::clearHomepageCache();
        });
    }
}
