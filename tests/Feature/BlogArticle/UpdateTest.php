<?php

use App\Models\BlogArticle;
use App\Models\BlogArticleComment;
use App\Models\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->blogArticles = BlogArticle::factory()->count(rand(1, 10))->create();

    $this->article = BlogArticle::inRandomOrder()->first();

    BlogArticleComment::factory()->count(rand(1, 10))->create(['blog_article_id' => $this->article->id]);
});

test('update blog article', function () {
    $response = $this->actingAs($this->admin)->putJson(
        '/admin/blog-articles/' . $this->article->id,
        [
            'id'        => $this->article->id,
            'title'     => 'New Title',
            'content'   => 'New Content',
            'tags'      => ['tag1', 'tag2'],
            'image'     => 'new-image.jpg',
            'imageFile' => UploadedFile::fake()->image('new-image.jpg'),
        ]
    );

    expect($response->json('success'))->toBeTrue()
                                      ->and($response->json('articleId'))->toBe($this->article->id);

    $editedArticle = BlogArticle::find($this->article->id);

    expect($editedArticle->title)->toBe('New Title')
                                 ->and($editedArticle->content)->toBe('New Content')
                                 ->and($editedArticle->tags)->toBe(['tag1', 'tag2'])
                                 ->and(file_exists(public_path('images/blog/' . $editedArticle->image)))->toBeTrue()
                                 ->and($editedArticle->image)->not()->toBe($this->article->image);

    $response->assertStatus(200);

    // Delete the image created
    unlink(public_path('images/blog/' . $editedArticle->image));
});

test('deny blog article update for user', function () {
    $response = $this->actingAs($this->user)->putJson(
        '/admin/blog-articles/' . $this->article->id,
        [
            'id'        => $this->article->id,
            'title'     => 'New Title',
            'content'   => 'New Content',
            'tags'      => ['tag1', 'tag2'],
            'image'     => 'new-image.jpg',
            'imageFile' => UploadedFile::fake()->image('new-image.jpg'),
        ]
    );

    $response->assertStatus(403);
});

test('deny blog article update with invalid data', function () {
    $response = $this->actingAs($this->admin)->putJson(
        '/admin/blog-articles/' . $this->article->id,
        [
            'id'        => $this->article->id,
            'title'     => '',
            'content'   => '',
            'tags'      => [],
            'image'     => '',
            'imageFile' => UploadedFile::fake()->image('new-image.jpg'),
        ]
    );

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['title', 'content', 'tags']);
});

test('deny blog article update with invalid image', function () {
    $response = $this->actingAs($this->admin)->putJson(
        '/admin/blog-articles/' . $this->article->id,
        [
            'id'        => $this->article->id,
            'title'     => 'New Title',
            'content'   => 'New Content',
            'tags'      => ['tag1', 'tag2'],
            'image'     => 'new-image.jpg',
            'imageFile' => 'invalid-image',
        ]
    );

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['imageFile']);
});

test('deny blog article update for guest', function () {
    $response = $this->putJson(
        '/admin/blog-articles/' . $this->article->id,
        [
            'id'        => $this->article->id,
            'title'     => 'New Title',
            'content'   => 'New Content',
            'tags'      => ['tag1', 'tag2'],
            'image'     => 'new-image.jpg',
            'imageFile' => UploadedFile::fake()->image('new-image.jpg'),
        ]
    );

    $response->assertStatus(403);
});
