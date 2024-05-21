<?php

use App\Models\BlogArticle;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    // Make some users
    $this->users = User::factory()->count(10)->create();

    // Create a random number of blogArticles
    $this->blogArticles = BlogArticle::factory()->count(rand(1, 10))->create(['tags' => rand(0, 1) === 1 ? ['laravel'] : []]);

});

test('get the articles of the blog without tag', function () {
    $response = $this->get('/blog');

    $response->assertInertia(function (AssertableInertia $page) {
        $page->component('Blog/Index');
        $page->has('articlesCount');
        $page->where('articlesCount', BlogArticle::count());
    });

    $response->assertStatus(200);
});

test('get the articles of the blog with a tag', function () {
    $tag = 'laravel';
    $response = $this->get('/blog/' . $tag);

    $response->assertInertia(function (AssertableInertia $page) use ($tag) {
        $page->component('Blog/Index');
        $page->has('articlesCount');
        $page->where('articlesCount', BlogArticle::whereJsonContains('tags', $tag)->count());
        $page->has('tag');
        $page->where('tag', $tag);
    });

    $response->assertStatus(200);
});


