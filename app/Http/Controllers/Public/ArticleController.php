<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::published()->with('user');

        if ($request->filled('kategori')) {
            $query->byCategory($request->kategori);
        }

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('content', 'like', '%' . $request->q . '%');
            });
        }

        $articles   = $query->latest('published_at')->paginate(9)->withQueryString();
        $categories = Article::published()->distinct()->pluck('category')->sort()->values();
        $popular    = Article::published()->latest('published_at')->take(5)->get();

        return view('public.articles.index', compact('articles', 'categories', 'popular'));
    }

    public function show(string $slug)
    {
        $article  = Article::published()->where('slug', $slug)->firstOrFail();
        $related  = Article::published()
                        ->where('category', $article->category)
                        ->where('id', '!=', $article->id)
                        ->latest('published_at')
                        ->take(4)
                        ->get();
        $categories = Article::published()->distinct()->pluck('category')->sort()->values();

        return view('public.articles.show', compact('article', 'related', 'categories'));
    }
}
