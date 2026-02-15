<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        return view('pages.articles.index', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return view('pages.articles.show', compact('article'));
    }
}
