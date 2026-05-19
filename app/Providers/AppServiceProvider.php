<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Collection;
use App\Models\Product;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('filament-login', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->ip() . '|' . $request->input('email')
            );
        });


       View::composer(
    ['partials.header', 'partials.footer'],
    function ($view) {

        $categories = Category::with([
            'subcategories.collections'
        ])
        ->orderBy('id')
        ->get();

        $targetNames = ['Decor & Lignting', 'Decor & Lighting', 'Office', 'Inlay Gallery'];
        $headerCategories = Category::with(['subcategories.collections'])
            ->whereIn('name', $targetNames)
            ->get()
            ->sortBy(function($model) use ($targetNames) {
                return array_search($model->name, $targetNames);
            })->values();

        if ($headerCategories->count() < 3) {
            $missing = 3 - $headerCategories->count();
            $fallbacks = Category::with(['subcategories.collections'])
                ->whereNotIn('id', $headerCategories->pluck('id'))
                ->orderBy('id', 'desc')
                ->take($missing)
                ->get();
            $headerCategories = $headerCategories->concat($fallbacks);
        }

        $featuredProducts = Product::where(function ($q) {
                $q->where('prod_trending', 1)
                  ->orWhere('prod_hotdeal', 1)
                  ->orWhere('prod_new_arrival', 1);
        })
        ->select('id','prod_name','prod_image','prod_slug','prod_trending','prod_hotdeal','prod_new_arrival', 'prod_price', 'prod_sale_price', 'prod_offer')
        ->orderByRaw('(prod_trending + prod_hotdeal + prod_new_arrival) DESC')
        ->get();
        $allCollections = Collection::select('id', 'col_name', 'col_slug')->get();

        $view->with([
            'full_categories' => $categories,
            'header_categories' => $headerCategories,
            'featured_products' => $featuredProducts,
            'all_collections' => $allCollections
        ]);
    }
);
    }
}
