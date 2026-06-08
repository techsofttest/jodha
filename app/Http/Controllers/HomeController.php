<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Seo;
use App\Models\Collection;
use App\Models\Category;
use App\Models\HomePageSection;
use Illuminate\Support\Facades\Cache;



class HomeController extends Controller
{

    public function index()
    {
        $data['seo'] = Seo::find(1);

        // Dynamic homepage sections keyed by display_order for direct access in the view
        $data['home_sections'] = Cache::rememberForever('homepage_sections_with_products', function () {
            return HomePageSection::where('status', true)
                ->orderBy('display_order', 'asc')
                ->get()
                ->each(fn($section) => $section->cached_products = $section->getProducts())
                ->keyBy('display_order');
        });

        $data['collections'] = Collection::orderBy('col_order', 'asc')->orderBy('col_name', 'asc')->get();

        $data['home_product'] = \App\Models\Product::with(['sizes', 'colors', 'images', 'category', 'subcategory'])
            ->where('prod_home', 1)
            ->first();

        $data['partners'] = \App\Models\Partner::all();

        $data['banners'] = \App\Models\Banner::where('is_active', true)->orderBy('order')->get();

        return view('pages.index', $data);
    }

    public function about()
    {
        $data['partners'] = \App\Models\Partner::all();
        $data['recognitions'] = \App\Models\Recognition::all();
        $data['cms'] = \App\Models\Cms::find(2);
        return view('pages.about', $data);
    }
}