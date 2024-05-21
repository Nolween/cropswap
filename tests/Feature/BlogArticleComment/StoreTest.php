<?php

use App\Models\BlogArticle;
use App\Models\User;

beforeEach(function () {
    $this->author = User::factory()->create();
    $this->user = User::factory()->create();
    // Create a blog article
    $this->blogArticle = BlogArticle::factory()->create();
});

test('store blog comment', function () {
    $response = $this->actingAs($this->user)->post(
        '/blog/article/comment',
        [
            'content'         => 'This is a comment',
            'blog_article_id' => $this->blogArticle->id,
        ]
    );

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'success',
        'comment' => [
            'avatar',
            'content',
            'created_at',
            'id',
            'updated_at',
            'user',
        ],
    ]);

});

test('store blog comment with invalid data', function () {
    $response = $this->actingAs($this->user)->postJson(
        '/blog/article/comment',
        [
            'content'         => '',
            'blog_article_id' => 34,
        ]
    );

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['content', 'blog_article_id']);
});

test('forbidden store blog comment as guest', function () {
    $response = $this->postJson(
        '/blog/article/comment',
        [
            'content'         => 'This is a comment',
            'blog_article_id' => $this->blogArticle->id,
        ]
    );

    $response->assertStatus(403);
});
