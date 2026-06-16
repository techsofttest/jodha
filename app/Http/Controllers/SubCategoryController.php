<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Seo;


class SubCategoryController extends Controller
{
   
    public function show()
    {
        $data['seo'] = Seo::find(1);
        
        return view('pages.index',$data);

    }


    public function showDetails($slug)
    {
        $data['seo'] = Seo::find(1);
        $data['subcategory'] = \App\Models\Subcategory::where('subcat_slug', $slug)->firstOrFail();
        
        $data['products'] = $data['subcategory']->products()->with(['colors', 'sizes'])->where('prod_isactive', 1)->get();
        
        return view('pages.subcategory-detail', $data);
    }


}

