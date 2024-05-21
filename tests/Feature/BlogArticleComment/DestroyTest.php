<?php

use App\Models\BlogArticle;
use App\Models\BlogArticleComment;
use App\Models\User;

beforeEach(function () {
    $this->author = User::factory()->create();
    $this->user = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    // Create a blog article
    $this->blogArticle = BlogArticle::factory()->create();

    BlogArticleComment::factory()->create([
        'blog_article_id' => $this->blogArticle->id,
        'user_id'         => $this->author->id,
    ]);
    $this->comment = BlogArticleComment::latest()->first();
});


test('destroy blog article comment from admin', function () {

    // Expect that 1 comment exists before
    expect(BlogArticleComment::count())->toBe(1);

    $response = $this->actingAs($this->admin)->deleteJson('/admin/comment/' . $this->comment->id);

    // Expect that no comment exists now
    expect(BlogArticleComment::count())->toBe(0);

    // Get the message to have success true
    expect($response['success'])->toBe(true);
    $response->assertStatus(200);
});

test('delete comment is denied for user', function () {

    // Expect that 1 comment exists before
    expect(BlogArticleComment::count())->toBe(1);

    $response = $this->actingAs($this->user)->deleteJson('/admin/comment/' . $this->comment->id);

    $response->assertStatus(403);
    // Expect that 1 comment exists now
    expect(BlogArticleComment::count())->toBe(1);

    // Get the message to have success false
    expect($response['success'])->toBe(false);
    $response->assertStatus(403);
});

test('delete comment is denied for guest', function () {

    // Expect that 1 comment exists before
    expect(BlogArticleComment::count())->toBe(1);

    $response = $this->deleteJson('/admin/comment/' . $this->comment->id);

    $response->assertStatus(403);
    // Expect that 1 comment exists now
    expect(BlogArticleComment::count())->toBe(1);

    // Get the message to have success false
    expect($response['success'])->toBe(false);
    $response->assertStatus(403);
});

test('inexisting comment cannot be deleted', function () {

    // Expect that 1 comment exists before
    expect(BlogArticleComment::count())->toBe(1);

    $response = $this->actingAs($this->admin)->deleteJson('/admin/comment/2');

    $response->assertStatus(404);
    // Expect that 1 comment exists now
    expect(BlogArticleComment::count())->toBe(1);

    $response->assertStatus(404);
});
