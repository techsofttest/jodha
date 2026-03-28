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

        $categories = Category::where('name', 'LIKE', "%$keyword%")->limit(5)->get();
        $subcategories = SubCategory::where('subcat_name', 'LIKE', "%$keyword%")->limit(5)->get();
        $collections = Collection::where('col_name', 'LIKE', "%$keyword%")->limit(5)->get();
        $products = Product::where('prod_name', 'LIKE', "%$keyword%")->limit(5)->get();

        return response()->json([
            'categories' => $categories,
            'subcategories' => $subcategories,
            'collections' => $collections,
            'products' => $products,
        ]);
    }
    
}