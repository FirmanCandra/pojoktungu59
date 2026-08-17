<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\WorkProgram;
use App\Models\Announcement;

class HomeController extends Controller
{
    public function index()
    {
        $latestArticles  = Article::published()->latest('created_at')->get();
        $featuredArticle = $latestArticles->first();
        $recentArticles  = $latestArticles->skip(1);
        $workPrograms    = WorkProgram::latest()->get();
        $announcements   = Announcement::active()->latest()->get();

        return view('public.home', compact(
            'featuredArticle',
            'recentArticles',
            'workPrograms',
            'announcements'
        ));
    }
}
