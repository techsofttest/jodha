<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Seo;

use App\Models\Collection;


class CollectionController extends Controller
{
   
    public function show()
    {
        $data['seo'] = Seo::find(1);

        $data['collections'] = Collection::orderBy('col_name')->get();
        
        return view('pages.collections',$data);

    }

    
    public function detail($slug)
    {
        $data['seo'] = Seo::find(1);
        $data['collection'] = Collection::where('col_slug', $slug)->firstOrFail();
        
        // You can paginate the products or just get them all. Using get() as requested.
        $data['products'] = $data['collection']->products()->where('prod_isactive', 1)->get();
        
        return view('pages.collection-detail', $data);
    }


}

