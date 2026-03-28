<?php

namespace App\Http\Controllers;

use App\Models\Seo;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $data = [];
        $data['seo'] = Seo::find(1); // Consistent with other pages
        
        return view('pages.contact', $data);
    }
}
