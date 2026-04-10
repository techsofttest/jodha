<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Faq;

class PolicyController extends Controller
{
    public function faq()
    {
        $faqs = Faq::orderBy('sort_order')->get();
        return view('pages.faq', compact('faqs'));
    }

    public function sitemap()
    {
        $categories = Category::with('subcategories')->orderBy('name')->get();
        $collections = Collection::orderBy('col_name')->get();
        return view('pages.sitemap', compact('categories', 'collections'));
    }

    public function privacy()
    {
        return view('pages.policies.privacy');
    }

    public function refund()
    {
        return view('pages.policies.refund');
    }

    public function shipping()
    {
        return view('pages.policies.shipping');
    }

    public function terms()
    {
        return view('pages.policies.terms');
    }
}
