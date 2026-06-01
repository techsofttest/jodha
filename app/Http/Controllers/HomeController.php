<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Seo;
use App\Models\Collection;
use App\Models\Category;



class HomeController extends Controller
{
   
    public function index()
    {
        $data['seo'] = Seo::find(1);

        $data['home_collections'] = Collection::with(['products' => function ($q) {
        $q->with(['colors', 'sizes'])
          ->where('prod_isactive', 1)
          ->latest()
          ->take(5);
        }])
        ->orderBy('col_order', 'asc')
        ->take(5)
        ->get()
        ->values(); 

        $data['collections'] = Collection::orderBy('col_order', 'asc')->orderBy('col_name', 'asc')->get();

        $data['home_product'] = \App\Models\Product::with(['sizes', 'colors', 'images', 'category', 'subcategory'])
            ->where('prod_home', 1)
            ->first();
            
        return view('pages.index',$data);

    }

    public function about()
    {
        $data['partners'] = \App\Models\Partner::all();
        $data['recognitions'] = \App\Models\Recognition::all();
        $data['cms'] = \App\Models\Cms::find(2);
        return view('pages.about', $data);
    }


}

