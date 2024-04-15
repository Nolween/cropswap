<?php

namespace App\Repositories\Eloquent;

use App\Models\BlogArticle;
use App\Repositories\Interfaces\BlogArticleRepositoryInterface;

class BlogArticleRepositoryEloquent implements BlogArticleRepositoryInterface
{
    public function index()
    {
        return BlogArticle::where('deleted_at', null)->with('comments')->get();
    }

    public function adminIndex()
    {
        return BlogArticle::all();
    }

    public function create()
    {
        return BlogArticle::all();
    }

    public function store()
    {
        return BlogArticle::all();
    }

    public function show()
    {
        return BlogArticle::all();
    }

    public function edit()
    {
        return BlogArticle::all();
    }

    public function update()
    {
        return BlogArticle::all();
    }

    public function destroy()
    {
        return BlogArticle::all();
    }
}
