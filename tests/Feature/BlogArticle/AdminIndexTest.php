<?php

use App\Models\BlogArticle;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->blogArticles = BlogArticle::factory()->count(rand(1, 10))->create();
});

test('access to blog articles admin index', function () {
    $response = $this->actingAs($this->admin)->get('/admin/blog-articles/index');

    $response->assertInertia(function (AssertableInertia $page) {
        $page->component('Admin/BlogArticle/Index');
        $page->has('articles');
        // Articles have the following keys: id, title, date, user_id, image, author, comments, tags
        $articles = $page->toArray()['props']['articles'];

        // Expect the articles have the correct keys
        expect($articles)->each->toHaveKeys(
            ['id', 'title', 'date', 'user_id', 'image', 'author', 'comments', 'tags']
        );
    });

    $response->assertStatus(200);
});

test('forbidden access to blog articles admin index', function () {
    $response = $this->actingAs($this->user)->get('/admin/blog-articles/index');

    $response->assertStatus(403);
});

