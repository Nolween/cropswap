<?php

use App\Models\BlogArticle;
use App\Models\BlogArticleComment;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    BlogArticle::factory()->count(5)->create(['tags' => ['tag1']]);
    BlogArticle::factory()->count(5)->create(['tags' => ['tag2']]);
    $this->blogArticles = BlogArticle::all();
    $this->article = BlogArticle::inRandomOrder()->first();

    BlogArticleComment::factory()->count(rand(1, 10))->create(['blog_article_id' => $this->article->id]);
});

test('fetch and show the blog article informations', function () {
    $response = $this->get('/blog/article/' . $this->article->id);

    $response->assertInertia(function (AssertableInertia $page) {
        $page->component('Blog/Show');
        $page->has('id');
        $page->where('id', $this->article->id);
        $page->has('title');
        $page->where('title', $this->article->title);
        $page->has('content');
        $page->where('content', $this->article->content);
        $page->has('created_at');
        $page->where('created_at', $this->article->created_at->format('Y-m-d\TH:i:s.u\Z'));
        $page->has('updated_at');
        $page->where('updated_at', $this->article->updated_at->format('Y-m-d\TH:i:s.u\Z'));
        $page->has('author');
        $page->where('author', $this->article->user->name);
        $page->has('comments', $this->article->comments->count(), fn(AssertableInertia $page) => $page
            ->has('id')
            ->has('content')
            ->has('created_at')
            ->has('updated_at')
            ->has('user')
            ->has('avatar')
        );
        $page->has('tags');
        $page->has('related_articles', 3, fn(AssertableInertia $page) => $page
            ->has('id')
            ->has('title')
            ->has('image')
            ->has('author')
            ->has('date')
        );
    });

    $response->assertStatus(200);
});


test('fetch and show the blog article informations with invalid id', function () {
    $response = $this->get('/blog/article/0');

    $response->assertStatus(404);
});
