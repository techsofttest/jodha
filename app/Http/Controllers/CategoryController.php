<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Seo;


class CategoryController extends Controller
{
   
    public function show()
    {
        $data['seo'] = Seo::find(1);
        $data['categories'] = \App\Models\Category::orderBy('name')->get();
        
        return view('pages.categories', $data);
    }


    public function showDetails($slug)
    {
        $data['seo'] = Seo::find(1);
        $data['category'] = \App\Models\Category::where('slug', $slug)->firstOrFail();
        
        $data['products'] = $data['category']->products()->with(['colors', 'sizes'])->where('prod_isactive', 1)->get();
        
        return view('pages.category-detail', $data);
    }

}

