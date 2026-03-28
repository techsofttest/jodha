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
        static::creating(function ($subcategory) {
            if (empty($subcategory->subcat_slug)) {
                $subcategory->subcat_slug = Str::slug($subcategory->subcat_name);
            }
        });
    }
}
