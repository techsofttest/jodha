<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Seo;
use App\Models\Product;
use App\Models\Partner;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Material;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $data['collections'] = Collection::orderBy('col_order', 'asc')->limit(5)->get();
        $query = Product::with(['category', 'subcategory', 'collection', 'images', 'colors', 'sizes'])
            ->where('prod_isactive', 1);

        // Search by keyword
        if ($request->has('search')) {
            $keyword = $request->get('search');
            $query->where(function($q) use ($keyword) {
                $q->where('prod_name', 'LIKE', "%$keyword%")
                  ->orWhere('prod_sku_code', 'LIKE', "%$keyword%");
            });
        }

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

    public function materialDetail($slug)
    {
        $material = Material::where('slug', $slug)->firstOrFail();

        $data['seo'] = Seo::find(1);
        $data['material'] = $material;
        $data['products'] = Product::with(['category', 'subcategory', 'collection', 'images', 'colors', 'sizes'])
            ->where('material_id', $material->id)
            ->where('prod_isactive', 1)
            ->get();

        return view('pages.material-detail', $data);
    }

    public function showDetails($slug)
    {
        $product = Product::with(['category', 'subcategory', 'collection', 'images', 'colors', 'sizes'])
            ->where('prod_slug', $slug)
            ->where('prod_isactive', 1)
            ->firstOrFail();

        // Related products from the same category, excluding current product
        $relatedProducts = Product::with(['colors', 'sizes'])
            ->where('prod_cat_id', $product->prod_cat_id)
            ->where('id', '!=', $product->id)
            ->where('prod_isactive', true)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        $partners = Partner::all();

        $data['seo'] = Seo::find(1);
        $data['product'] = $product;
        $data['relatedProducts'] = $relatedProducts;
        $data['partners'] = $partners;
        
        return view('pages.product-detail', $data);
    }

    public function quickInfo($id)
    {
        $product = Product::with(['colors', 'sizes', 'images', 'category', 'subcategory', 'material'])
            ->where('prod_isactive', 1)
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'prod_name' => $product->prod_name,
                'prod_slug' => $product->prod_slug,
                'prod_sku_code' => $product->prod_sku_code,
                'prod_image' => asset('storage/' . $product->prod_image),
                'prod_price' => $product->prod_price,
                'prod_sale_price' => $product->prod_sale_price,
                'offer_percentage' => $product->offer_percentage,
                'prod_description' => $product->prod_description,
                'prod_material' => $product->prod_material,
                'prod_measurements' => $product->prod_measurements,
                'colors' => $product->colors,
                'sizes' => $product->sizes,
                'images' => $product->images->map(function ($img) {
                    return [
                        'id' => $img->id,
                        'image_path' => asset('storage/' . $img->image_path),
                    ];
                }),
                'category' => $product->category ? [
                    'name' => $product->category->name,
                    'slug' => $product->category->slug,
                ] : null,
                'subcategory' => $product->subcategory ? [
                    'subcat_name' => $product->subcategory->subcat_name,
                ] : null,
                'material' => $product->material ? [
                    'name' => $product->material->name,
                ] : null,
                'url' => route('product.show', $product->prod_slug),
            ]
        ]);
    }
}
