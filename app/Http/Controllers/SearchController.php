<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Collection;
use App\Models\Product;

class SearchController extends Controller
{

    public function suggestions(Request $request)
    {
        $keyword = $request->keyword;

        if (!$keyword || strlen($keyword) < 2) {
            return response()->json([
                'categories' => [],
                'subcategories' => [],
                'collections' => [],
                'products' => [],
            ]);
        }

        $categories = Category::where('name', 'LIKE', "%$keyword%")
            ->limit(5)
            ->get()
            ->map(function ($cat) {
                return [
                    'name' => $cat->name,
                    'url' => route('category.show', $cat->slug),
                    'image' => $cat->image ? asset('storage/' . $cat->image) : asset('images/placeholder.jpg'),
                ];
            });

        $subcategories = SubCategory::where('subcat_name', 'LIKE', "%$keyword%")
            ->limit(5)
            ->get()
            ->map(function ($sub) {
                return [
                    'name' => $sub->subcat_name,
                    'url' => route('subcategory.show', $sub->subcat_slug),
                    'image' => $sub->subcat_image ? asset('storage/' . $sub->subcat_image) : asset('images/placeholder.jpg'),
                ];
            });

        $collections = Collection::where('col_name', 'LIKE', "%$keyword%")
            ->limit(5)
            ->get()
            ->map(function ($col) {
                return [
                    'name' => $col->col_name,
                    'url' => route('collections.show', $col->col_slug),
                    'image' => $col->col_image ? asset('storage/' . $col->col_image) : asset('images/placeholder.jpg'),
                ];
            });

        $products = Product::where('prod_name', 'LIKE', "%$keyword%")
            ->orWhere('prod_sku_code', 'LIKE', "%$keyword%")
            ->limit(5)
            ->get()
            ->map(function ($prod) {
                return [
                    'name' => $prod->prod_name,
                    'url' => route('product.show', $prod->prod_slug),
                    'image' => $prod->prod_image ? asset('storage/' . $prod->prod_image) : asset('images/placeholder.jpg'),
                    'price' => $prod->prod_sale_price ?? $prod->prod_price,
                ];
            });

        return response()->json([
            'categories' => $categories,
            'subcategories' => $subcategories,
            'collections' => $collections,
            'products' => $products,
        ]);
    }
    
}