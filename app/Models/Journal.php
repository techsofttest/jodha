<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Journal extends Model
{
    //
    protected $fillable = ['journal_category_id', 'title', 'label', 'content', 'date', 'image', 'slug','meta_title','meta_description','meta_keywords'];

    protected static function booted()
    {
        static::creating(function ($journal) {
            if (empty($journal->slug)) {
                $journal->slug = Str::slug($journal->title);
            }
        });

        static::updating(function ($journal) {
            if (empty($journal->slug)) {
                $journal->slug = Str::slug($journal->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(JournalCategory::class, 'journal_category_id');
    }
}
