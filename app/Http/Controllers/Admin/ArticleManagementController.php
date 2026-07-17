<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleManagementController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();

        return view(
            'admin.articles.index',
            compact('articles')
        );
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'title' => 'required',

            'category' => 'required',

            'content' => 'required',

            'author' => 'nullable',

            'published_at' => 'nullable|date'

        ]);

        Article::create($request->all());

        return redirect()
            ->route('admin.articles')
            ->with('success','Article berhasil ditambahkan.');
    }

    public function show(Article $article)
    {
        return view(
            'admin.articles.show',
            compact('article')
        );
    }

    public function edit(Article $article)
    {
        return view(
            'admin.articles.edit',
            compact('article')
        );
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([

            'title' => 'required',

            'category' => 'required',

            'content' => 'required',

            'author' => 'nullable',

            'published_at' => 'nullable|date'

        ]);

        $article->update($request->all());

        return redirect()
            ->route('admin.articles')
            ->with('success','Article berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()
            ->route('admin.articles')
            ->with('success','Article berhasil dihapus.');
    }
}