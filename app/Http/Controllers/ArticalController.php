<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\JournalCategory;
use Illuminate\Http\Request;

class ArticalController extends Controller
{
    public function index(Request $request)
    {
        $categories = JournalCategory::withCount('journals')->get();
        
        $journals = Journal::with('category')
            ->when($request->category, function ($query) use ($request) {
                return $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            })
            ->latest()
            ->paginate(12);

        return view('pages.articles', compact('categories', 'journals'));
    }

    public function detail($slug)
    {
        $journal = Journal::where('slug', $slug)->firstOrFail();
        
        $relatedJournals = Journal::where('id', '!=', $journal->id)
            ->where('journal_category_id', $journal->journal_category_id)
            ->take(3)
            ->get();

        return view('pages.articles-detailed', compact('journal', 'relatedJournals'));
    }
}
