<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogArticleRequest;
use App\Http\Requests\UpdateBlogArticleRequest;
use App\Models\BlogArticle;
use App\Repositories\Interfaces\BlogArticleRepositoryInterface;
use Inertia\Inertia;

class BlogArticleController extends Controller
{

    protected $blogArticleRepository;

    public function __construct(BlogArticleRepositoryInterface $blogArticleRepository)
    {
        $this->blogArticleRepository = $blogArticleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = $this->blogArticleRepository->index();

        return response()->json($articles);
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
    public function store(StoreBlogArticleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogArticle $blogArticle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogArticle $blogArticle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogArticleRequest $request, BlogArticle $blogArticle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogArticle $blogArticle)
    {
        //
    }
}
