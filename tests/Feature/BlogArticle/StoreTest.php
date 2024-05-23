<?php

use App\Models\BlogArticle;
use App\Models\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->user = User::factory()->create(['role' => 'user']);
});

test('store blog article', function () {
    $response = $this->actingAs($this->admin)->postJson('/admin/blog-articles', [
        'title'     => 'This is a title',
        'content'   => 'This is a content',
        'image'     => 'image.jpg',
        'tags'      => ['tag1', 'tag2'],
        'imageFile' => UploadedFile::fake()->image('image.jpg'),
        'id'        => 0,
    ]);

    expect($response->json('success'))->toBeTrue();

    // Expect to have a Blog article in the database
    expect(BlogArticle::count())->toBe(1);
    expect(BlogArticle::first()->title)->toBe('This is a title');
    expect(BlogArticle::first()->content)->toBe('This is a content');
    expect(BlogArticle::first()->tags)->toBe(['tag1', 'tag2']);

    // Expect to have an image in public/images/blog folder with the image name
    expect(file_exists(public_path('images/blog/' . BlogArticle::first()->image)))->toBeTrue();

    $response->assertStatus(200);

    // Delete the image created
    unlink(public_path('images/blog/' . BlogArticle::first()->image));
});

test('store blog article with invalid data', function () {
    $response = $this->actingAs($this->admin)->postJson('/admin/blog-articles', [
        'title'     => '',
        'content'   => '',
        'image'     => '',
        'tags'      => [],
        'imageFile' => UploadedFile::fake()->image('image.jpg'),
        'id'        => 0,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['title', 'content', 'tags']);
});

test('deny blog article creation for user', function() {

    $response = $this->actingAs($this->user)->postJson('/admin/blog-articles', [
        'title'     => 'This is a title',
        'content'   => 'This is a content',
        'image'     => 'image.jpg',
        'tags'      => ['tag1', 'tag2'],
        'imageFile' => UploadedFile::fake()->image('image.jpg'),
        'id'        => 0,
    ]);

    $response->assertStatus(403);

});

test('deny blog article creation for guest', function() {

    $response = $this->postJson('/admin/blog-articles', [
        'title'     => 'This is a title',
        'content'   => 'This is a content',
        'image'     => 'image.jpg',
        'tags'      => ['tag1', 'tag2'],
        'imageFile' => UploadedFile::fake()->image('image.jpg'),
        'id'        => 0,
    ]);

    $response->assertStatus(403);

});

test('deny blog article creation with invalid image', function() {

    $response = $this->actingAs($this->admin)->postJson('/admin/blog-articles', [
        'title'     => 'This is a title',
        'content'   => 'This is a content',
        'image'     => 'image.jpg',
        'tags'      => ['tag1', 'tag2'],
        'imageFile' => UploadedFile::fake()->create('image.pdf'),
        'id'        => 0,
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['imageFile']);

});
