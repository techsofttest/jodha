<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'prod_sku_code',
        'prod_cat_id',
        'prod_subcat_id',
        'prod_col_id',
        'prod_name',
        'prod_slug',
        'prod_description',
        'prod_material',
        'prod_measurements',
        'prod_image',
        'prod_price',
        'prod_offer',
        'prod_sale_price',
        'prod_stock',
        'shipping_cost',
        'prod_expected_delivery',
        'prod_isactive',
        'prod_trending',
        'prod_hotdeal',
        'prod_deal_of_day',
        'prod_new_arrival',
        'prod_home',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'prod_cat_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'prod_subcat_id');
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class, 'prod_col_id');
    }

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->prod_slug)) {
                $product->prod_slug = Str::slug($product->prod_name);
            }
        });

        static::saving(function ($product) {
            if ($product->prod_home) {
                static::where('id', '!=', $product->id)->update(['prod_home' => false]);
            }
        });
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getOfferPercentageAttribute()
    {
        if ($this->prod_price > 0 && $this->prod_sale_price > 0) {
            return round((($this->prod_price - $this->prod_sale_price) / $this->prod_price) * 100);
        }

        return 0;
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'review_product_id');
    }
}
