<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Seo;
use App\Models\Product;
use App\Models\Partner;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'subcategory', 'collection', 'images', 'colors', 'sizes'])
            ->where('prod_isactive', 1);

        // Filter by categories (multiple)
        if ($request->has('categories')) {
            $categories = explode(',', $request->get('categories'));
            $query->whereIn('prod_cat_id', $categories);
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('prod_price', '>=', $request->get('min_price'));
        }
        if ($request->has('max_price')) {
            $query->where('prod_price', '<=', $request->get('max_price'));
        }

        // Sorting
        $sort = $request->get('sort', 'best-selling');
        switch ($sort) {
            case 'a-z':
                $query->orderBy('prod_name', 'asc');
                break;
            case 'z-a':
                $query->orderBy('prod_name', 'desc');
                break;
            case 'low-high':
                $query->orderBy('prod_price', 'asc');
                break;
            case 'high-low':
                $query->orderBy('prod_price', 'desc');
                break;
            case 'best-selling':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);

        // If AJAX request, return rendered product cards
        if ($request->ajax()) {
            $html = '';
            foreach ($products as $product) {
                $html .= view('components.product-card', compact('product'))->render();
            }
            
            return response()->json([
                'html' => $html,
                'pagination' => (string) $products->links('vendor.pagination.luxury'), // We'll need to create this if it doesn't exist, or use standard
                'total' => $products->total(),
            ]);
        }

        $data['seo'] = Seo::find(1);
        $data['products'] = $products;
        $data['categories'] = Category::withCount('products')->get();
        $data['max_range'] = Product::max('prod_price') ?? 100000;
        
        return view('pages.products', $data);
    }

    public function showDetails($slug)
    {
        $product = Product::with(['category', 'subcategory', 'collection', 'images', 'colors', 'sizes'])
            ->where('prod_slug', $slug)
            ->where('prod_isactive', 1)
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
