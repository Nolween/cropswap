<?php

use App\Models\BlogArticle;
use App\Models\User;

beforeEach(function(){

    $this->tag = 'laravel';

    $this->users = User::factory()->count(10)->create();
    $this->articles = BlogArticle::factory()->count(rand(1,20))->create(['tags' => rand(0, 1) ? [$this->tag] : []]);

});

test('fetch articles details without tag', function () {
    $response = $this->get('/blog/index');

    // Expect that response is an array of objects
    expect($response->json())->toBeArray();

    // Expect that the response has the same number of articles as the database
    expect($response->json())->toHaveCount(BlogArticle::count());

    // Expect that each object of the array has the following keys: image, title, content, created_at, updated_at, user, comments
    expect($response->json())->each->toHaveKeys(['image', 'title', 'content', 'created_at', 'updated_at', 'user_id', 'comments']);

    $response->assertStatus(200);
});

test('fetch articles details with tag', function () {
    $response = $this->get('/blog/index?tag='. $this->tag);

    // Expect that response is an array of objects
    expect($response->json())->toBeArray();

    // Expect that the response has the same number of articles as the database
    expect($response->json())->toHaveCount(BlogArticle::whereJsonContains('tags', [$this-> tag])->count());

    // Expect that each object of the array has the following keys: image, title, content, created_at, updated_at, user, comments
    expect($response->json())->each->toHaveKeys(['image', 'title', 'content', 'created_at', 'updated_at', 'user_id', 'comments']);

    $response->assertStatus(200);
});


