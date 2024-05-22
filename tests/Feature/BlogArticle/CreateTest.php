<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    $this->adminUser = User::factory()->create(['role' => 'admin']);
});

test('access to admin blog creation page', function () {
    $response = $this->actingAs($this->adminUser)->get('/admin/blog-articles/create');

    $response->assertInertia(function (AssertableInertia $page) {
        $page->component('Admin/BlogArticle/Create');
    });

    $response->assertStatus(200);
});

test('forbidden access to admin blog creation page', function () {
    $response = $this->get('/admin/blog-articles/create');

    $response->assertStatus(403);
});

test('access denied to create blog article as user', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user)->get('/admin/blog-articles/create');

    $response->assertStatus(403);
});
