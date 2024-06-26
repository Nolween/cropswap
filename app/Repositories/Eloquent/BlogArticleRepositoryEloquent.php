<?php

namespace App\Repositories\Eloquent;

use App\Models\BlogArticle;
use App\Repositories\Interfaces\BlogArticleRepositoryInterface;

class BlogArticleRepositoryEloquent implements BlogArticleRepositoryInterface
{
    public function index(?string $tag = null)
    {
        $query = BlogArticle::where('deleted_at', null)
                            ->with('comments')
                            ->orderBy('created_at', 'desc');

        if ($tag) {
            $query->whereJsonContains('tags', $tag);
        }

        return $query->get();
    }

    public function adminIndex()
    {
        return BlogArticle::select(['id', 'user_id', 'created_at as date', 'tags', 'title', 'image'])
                          ->with('user')
                          ->withCount('comments as comments')
                          ->orderBy('created_at', 'desc')
                          ->get();
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

    public function edit(BlogArticle $blogArticle)
    {
        return BlogArticle::find($blogArticle->id);
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
