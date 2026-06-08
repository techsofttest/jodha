<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class HomePageSection extends Model
{
    protected $fillable = [
        'title',
        'section_type',
        'reference_id',
        'product_limit',
        'display_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'product_limit' => 'integer',
        'display_order' => 'integer',
        'reference_id' => 'integer',
    ];

    /**
     * Boot the model and register lifecycle hooks.
     */
    protected static function booted()
    {
        // Prevent creating more than 5 sections
        static::creating(function ($section) {
            if (static::count() >= 5) {
                throw new \Exception('Maximum of 5 homepage sections allowed.');
            }
        });

        // Clear homepage cache on any change
        static::saved(function () {
            static::clearHomepageCache();
        });

        static::deleted(function () {
            static::clearHomepageCache();
        });
    }

    /**
     * Resolve the referenced entity (Category, Subcategory, or Collection).
     */
    public function referencedEntity()
    {
        return match ($this->section_type) {
            'category' => Category::find($this->reference_id),
            'subcategory' => Subcategory::find($this->reference_id),
            'collection' => Collection::find($this->reference_id),
            default => null,
        };
    }

    /**
     * Get products belonging to the referenced entity, respecting the product limit.
     */
    public function getProducts()
    {
        $query = Product::with(['colors', 'sizes', 'images'])
            ->where('prod_isactive', 1);

        $query = match ($this->section_type) {
            'category' => $query->where('prod_cat_id', $this->reference_id),
            'subcategory' => $query->where('prod_subcat_id', $this->reference_id),
            'collection' => $query->where('prod_col_id', $this->reference_id),
            default => $query->whereRaw('1 = 0'), // return empty
        };

        return $query->latest()->take($this->product_limit)->get();
    }

    /**
     * Generate a "View All" URL based on the section type and referenced entity's slug.
     */
    public function getViewAllUrlAttribute()
    {
        $entity = $this->referencedEntity();

        if (!$entity) {
            return '#';
        }

        return match ($this->section_type) {
            'category' => route('category.show', $entity->slug),
            'subcategory' => route('subcategory.show', $entity->subcat_slug),
            'collection' => route('collections.show', $entity->col_slug),
            default => '#',
        };
    }

    /**
     * Get the display name of the referenced entity.
     */
    public function getReferenceNameAttribute()
    {
        $entity = $this->referencedEntity();

        if (!$entity) {
            return 'N/A';
        }

        return match ($this->section_type) {
            'category' => $entity->name,
            'subcategory' => $entity->subcat_name,
            'collection' => $entity->col_name,
            default => 'N/A',
        };
    }

    /**
     * Clear all homepage-related caches.
     */
    public static function clearHomepageCache()
    {
        Cache::forget('homepage_sections');
        Cache::forget('homepage_sections_with_products');
    }
}
