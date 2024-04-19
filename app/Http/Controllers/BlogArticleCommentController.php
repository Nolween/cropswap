<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogArticleCommentRequest;
use App\Http\Requests\UpdateBlogArticleCommentRequest;
use App\Models\BlogArticleComment;

class BlogArticleCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogArticleCommentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogArticleComment $blogArticleComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogArticleComment $blogArticleComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogArticleCommentRequest $request, BlogArticleComment $blogArticleComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogArticleComment $blogArticleComment)
    {
        $blogArticleComment->delete();
        return response()->json(['success' => true, 'message' => 'Commentaire supprimé']);
    }
}
