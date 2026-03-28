<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Seo;
use App\Models\Product;
use App\Models\Partner;


class ProductController extends Controller
{
   
    public function show()
    {
        $data['seo'] = Seo::find(1);
        
        return view('pages.index',$data);

    }


    public function showDetails($slug)
    {
        $product = Product::with(['category', 'subcategory', 'collection', 'images', 'colors', 'sizes'])
            ->where('prod_slug', $slug)
            ->where('prod_isactive',1)
            ->firstOrFail();

        // Related products from the same subcategory, excluding current product
        $relatedProducts = Product::with(['colors'])
            ->where('prod_subcat_id', $product->prod_subcat_id)
            ->where('id', '!=', $product->id)
            ->where('prod_isactive', true)
            ->limit(5)
            ->get();

        // If less than 5 related products, fill with products from the same category
        if ($relatedProducts->count() < 5) {
            $remaining = 5 - $relatedProducts->count();
            $excludeIds = $relatedProducts->pluck('id')->push($product->id)->toArray();

            $categoryProducts = Product::with(['colors'])
                ->where('prod_cat_id', $product->prod_cat_id)
                ->whereNotIn('id', $excludeIds)
                ->where('prod_isactive', true)
                ->limit($remaining)
                ->get();

            $relatedProducts = $relatedProducts->merge($categoryProducts);
        }

        $partners = Partner::all();

        $data['seo'] = Seo::find(1);
        $data['product'] = $product;
        $data['relatedProducts'] = $relatedProducts;
        $data['partners'] = $partners;
        
        return view('pages.product-detail', $data);
    }


}
