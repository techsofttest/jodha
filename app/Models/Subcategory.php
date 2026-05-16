<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subcategory extends Model
{
    //
    protected $fillable = ['subcat_cat_id', 'subcat_name', 'subcat_description', 'subcat_image', 'subcat_slug', 'meta_title', 'meta_description', 'meta_keywords'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'subcat_cat_id');
    }

    public function collections()
    {
        return $this->hasMany(Collection::class, 'col_subcat_id');
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
    }
}
