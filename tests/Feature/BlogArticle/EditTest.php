<?php

use App\Models\BlogArticle;
use App\Models\BlogArticleComment;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->blogArticles = BlogArticle::factory()->count(rand(1, 10))->create();

    $this->article = BlogArticle::inRandomOrder()->first();

    BlogArticleComment::factory()->count(rand(1, 10))->create(['blog_article_id' => $this->article->id]);
});

test('show the form editing for the blog article', function () {
    $response = $this->actingAs($this->admin)->get('/admin/blog-articles/' . $this->article->id);

    $response->assertInertia(function (AssertableInertia $page) {
        $page->component('Admin/BlogArticle/Create');
        $page->has('title');
        $page->has('article', fn(AssertableInertia $page) => $page
            ->where('id', $this->article->id)
            ->where('title', $this->article->title)
            ->where('content', $this->article->content)
            ->where('tags', $this->article->tags)
            ->where('image', $this->article->image)
            ->where('user_id', $this->article->user_id)
            ->has('comments', $this->article->comments->count(), fn(AssertableInertia $page) => $page
                ->has('id')
                ->has('content')
                ->has('created_at')
                ->has('updated_at')
                ->has('deleted_at')
                ->has('user')
                ->has('blog_article_id')
                ->has('user_id')
                ->etc()
            )
            ->where(
                'deleted_at',
                $this->article->deleted_at ? $this->article->deleted_at->format('Y-m-d\TH:i:s.u\Z') : null
            )
            ->where(
                'created_at',
                $this->article->created_at ? $this->article->created_at->format('Y-m-d\TH:i:s.u\Z') : null
            )
            ->where(
                'updated_at',
                $this->article->updated_at ? $this->article->updated_at->format('Y-m-d\TH:i:s.u\Z') : null
            )
            ->etc()
        );
        $page->has('comments', $this->article->comments->count(), function (AssertableInertia $page) {
            $page->has('id');
            $page->has('content');
            $page->has('created_at');
            $page->has('updated_at');
            $page->has('user');
        });
    });

    $response->assertStatus(200);
});

test('deny blog article edit form for user', function () {
    $response = $this->actingAs($this->user)->get('/admin/blog-articles/' . $this->article->id);

    $response->assertStatus(403);
});

test('deny blog article edit form for guest', function () {
    $response = $this->get('/admin/blog-articles/' . $this->article->id);

    $response->assertStatus(403);
});

test('show the form editing for the blog article with invalid id', function () {
    $response = $this->actingAs($this->admin)->get('/admin/blog-articles/0');

    $response->assertStatus(404);
});
