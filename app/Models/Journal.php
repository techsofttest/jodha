<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Journal extends Model
{
    //
    protected $fillable = ['title', 'label', 'content', 'date', 'image', 'slug','meta_title','meta_description','meta_keywords'];

    protected static function booted()
    {
        static::creating(function ($journal) {
            if (empty($journal->slug)) {
                $journal->slug = Str::slug($journal->name);
            }
        });
    }
}
