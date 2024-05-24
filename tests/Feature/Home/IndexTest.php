<?php

use App\Models\BlogArticle;
use App\Models\Crop;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->users = User::factory()->count(10)->create();
    $this->crop = Crop::factory()->count(11)->create(['user_id' => $this->user->id]);
    $this->articles = BlogArticle::factory()->count(6)->create();
});

test('access to the home page', function () {
    $response = $this->get('/');

    $response->assertInertia(fn(AssertableInertia $page) => $page
        ->component('Home')
        ->has('articles')
        ->has('crops')
        ->has('articles', 5, fn (AssertableInertia $page) => $page
            ->has('id')
            ->has('user_id')
            ->has('title')
            ->has('image')
            ->has('content')
            ->has('tags')
            ->etc()
        )
        ->has(
            'crops', 10, fn(AssertableInertia $page) => $page
            ->has('id')
            ->has('icon')
            ->has('position')
            ->has('name')
            ->has('description')
            ->etc()
        )
        ->etc()
    );

    $response->assertStatus(200);
});

