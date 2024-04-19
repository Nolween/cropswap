<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogArticleRequest;
use App\Http\Requests\UpdateBlogArticleRequest;
use App\Models\BlogArticle;
use App\Repositories\Interfaces\BlogArticleRepositoryInterface;
use Illuminate\Support\Facades\Gate;
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

    public function adminIndex()
    {
        Gate::authorize('adminIndex', BlogArticle::class);

        $articles = $this->blogArticleRepository->adminIndex();

        // Format $articles
        $articles = $articles->map(function ($article) {
            return [
                'id'       => $article->id,
                'user_id'  => $article->user_id,
                'title'    => $article->title,
                'image'    => $article->image,
                'author'   => $article->user->name ?? 'Auteur inconnu',
                'date'     => $article->date,
                'tags'     => implode(' ', $article->tags),
                'comments' => $article->comments,
            ];
        });


        return Inertia::render('Admin/BlogArticle/Index', [
            'articles' => $articles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/BlogArticle/Create', [
            'title' => 'Admin Blog Article Create',
        ]);
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
        foreach ($blogArticle->tags as $tag) {
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
            'id'               => $blogArticle->id,
            'title'            => $blogArticle->title,
            'content'          => $blogArticle->content,
            'image'            => $blogArticle->image,
            'author'           => $blogArticle->user->name ?? 'Unknown author',
            'created_at'       => $blogArticle->created_at,
            'updated_at'       => $blogArticle->updated_at,
            'tags'             => $blogArticle->tags,
            'related_articles' => $relatedArticles
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogArticle $blogArticle)
    {
        return Inertia::render('Admin/BlogArticle/Create', [
            'title'    => 'Admin Blog Article Edit',
            'article'  => $blogArticle,
            'comments' => $blogArticle->comments->map(function ($comment) {
                return [
                    'id'         => $comment->id,
                    'content'    => $comment->content,
                    'created_at' => $comment->created_at,
                    'updated_at' => $comment->updated_at,
                    'user'       => $comment->user->name ?? 'Auteur inconnu'
                ];
            })
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogArticleRequest $request, BlogArticle $blogArticle)
    {
        // Moving the image to the right folder
        if ($request->hasFile('imageFile')) {

            $image = $request->file('imageFile');
            $imageName = time() . '.' . $image->extension();
            // Move the image to the right folder
            $image->move(public_path('images/blog'), $imageName);

            // Update the request with the new image name
            $request->merge(['image' => $imageName]);

        }

        $blogArticle->update($request->all());


        return response()->json(['success' => true, 'articleId' => $blogArticle->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogArticle $blogArticle)
    {
        //
    }
}
