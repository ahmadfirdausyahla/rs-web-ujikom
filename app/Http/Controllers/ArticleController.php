<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('admin.article.index', compact('article'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'articles');
        }

        Article::create($data);

        return redirect()->route('admin.article.index')
            ->with('success', 'Article created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('admin.article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('admin.article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $data = $request->validated();

        if ($data->hasFile('image')) {
            if ($article->image){
                $this->deleteImage($article->image);
            }
            $data['image'] = $this->uploadImage($request->file('image'), 'articles');
        }

        $article->updated($data);

        return redirect()->route('admin.article.index')
            ->with('success', 'Article edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if($article->image){
            $this->deleteImage($article->image);
        }

        $article->delete();

        return redirect()->route('admin.article.index')
            ->with('success', 'Article deleted successfully.');
    }
}
