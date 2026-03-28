<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $fillable = ['product_id', 'size', 'stock', 'price', 'offer', 'offer_price'];
    //

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
