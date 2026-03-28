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
        
        return view('pages.index',$data);

    }


}

