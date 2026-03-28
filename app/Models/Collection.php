<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Collection extends Model
{
    //
    protected $fillable = ['col_cat_id', 'col_subcat_id', 'col_name', 'col_image', 'col_description', 'col_slug', 'meta_title', 'meta_description', 'meta_keywords'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'col_cat_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'col_subcat_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'prod_col_id');
    }


    protected static function booted()
    {

        static::creating(function ($collection) {
            if (empty($collection->col_slug)) {
                $collection->col_slug = Str::slug($collection->col_name);
            }
        });
    }
}
