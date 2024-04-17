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

    public function homeBlog()
    {
        return Inertia::render('Blog/Index', [
            'articlesCount' => BlogArticle::count(),
        ]);
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
        $query = BlogArticle::query();

        // Find 3 articles with at least one tag in common
        foreach (json_decode($blogArticle->tags) as $tag) {
            $query->orWhereJsonContains('tags', $tag);
        }

        $relatedArticles = BlogArticle::where('id', '!=', $blogArticle->id)
                                      ->limit(3)
                                      ->inRandomOrder()
                                      ->get();

        // Format $relatedArticles
        $relatedArticles = $relatedArticles->map(function ($article) {
            return [
                'id'     => $article->id,
                'title'  => $article->title,
                'image'  => $article->image,
                'author' => $article->user->name ?? 'Unknown author',
                'date'   => $article->created_at->format('d/m/Y'),
            ];
        });

        return Inertia::render('Blog/Show', [
            'id'              => $blogArticle->id,
            'title'           => $blogArticle->title,
            'content'         => $blogArticle->content,
            'image'           => $blogArticle->image,
            'author'         => $blogArticle->user->name ?? 'Unknown author',
            'created_at'      => $blogArticle->created_at,
            'updated_at'      => $blogArticle->updated_at,
            'tags'            => $blogArticle->tags,
            'related_articles' => $relatedArticles
        ]);
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
