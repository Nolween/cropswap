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
        //    Create a new comment for the blog article
        $newComment = BlogArticleComment::create([
            'content'         => $request->get('content'),
            'user_id'         => auth()->id(),
            'blog_article_id' => $request->get('blog_article_id'),
        ]);

        return response()->json([
            'success' => true,
            'comment' => [
                'avatar'     => $newComment->user->image ? filter_var($newComment->user->image, FILTER_VALIDATE_URL) !== false ? $newComment->user->image : '/images/user/' . $newComment->user->image : 'empty.svg',
                'content'    => $newComment->content,
                'created_at' => $newComment->created_at,
                'id'         => $newComment->id,
                'updated_at' => $newComment->updated_at,
                'user'       => $newComment->user->name,
            ]
        ]);
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
