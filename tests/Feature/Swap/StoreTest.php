<?php

use App\Models\Swap;
use App\Models\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
});

test('store new swap', function () {
    $response = $this->actingAs($this->admin)->postJson('/admin/swap', [
        'name'      => 'New Swap',
        'category'  => 'vegetable',
        'image'     => 'image.jpg',
        'imageFile' => UploadedFile::fake()->image('image.jpg')
    ]);

    $response->assertStatus(200);
    expect($response->json('success'))->toBeTrue();
    $createdSwap = Swap::first();
    expect($createdSwap->name)->toBe('New Swap');
    expect($createdSwap->category)->toBe('vegetable');
    expect($createdSwap->image)->toBe('new_swap.jpg');
//    Delete image after insert
    unlink(public_path('images/food/' . $createdSwap->image));
});

test('cannot store new swap with invalid data', function () {
    $response = $this->actingAs($this->admin)->postJson('/admin/swap', [
        'name'      => '',
        'category'  => '',
        'image'     => '',
        'imageFile' => null
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['name', 'category', 'image', 'imageFile']);
});

test('cannot store new swap as user', function () {
    $response = $this->actingAs($this->user)->postJson('/admin/swap', [
        'name'      => 'New Swap',
        'category'  => 'vegetable',
        'image'     => 'image.jpg',
        'imageFile' => UploadedFile::fake()->image('image.jpg')
    ]);

    $response->assertStatus(403);
});

test('cannot store new swap as guest', function () {
    $response = $this->postJson('/admin/swap', [
        'name'      => 'New Swap',
        'category'  => 'vegetable',
        'image'     => 'image.jpg',
        'imageFile' => UploadedFile::fake()->image('image.jpg')
    ]);

    $response->assertStatus(403);
});
