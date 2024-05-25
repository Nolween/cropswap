<?php

use App\Models\Swap;
use App\Models\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->swap = Swap::factory()->create();

});

test('updates swap', function () {
    $response = $this->actingAs($this->admin)->putJson('/admin/swap/' . $this->swap->id,
        [
            'id' => $this->swap->id,
            'name' => 'New Swap Name',
            'category' => 'vegetable',
            'image' => 'new-image.jpg',
            'imageFile' => UploadedFile::fake()->image('new-image.jpg')
        ]);


    $response->assertStatus(200);
    expect($response->json('success'))->toBeTrue();
    expect($this->swap->fresh()->name)->toBe('New Swap Name');
    expect($this->swap->fresh()->category)->toBe('vegetable');
    expect(file_exists(public_path('images/food/' . $this->swap->fresh()->image)))->toBeTrue();

});

test('cannot update swap with invalid data', function () {
    $response = $this->actingAs($this->admin)->putJson('/admin/swap/' . $this->swap->id,
        [
            'id' => $this->swap->id,
            'name' => '',
            'category' => '',
            'image' => '',
            'imageFile' => null
        ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['name', 'category', 'image', 'imageFile']);
});

test('cannot update swap as user', function () {
    $response = $this->actingAs($this->user)->putJson('/admin/swap/' . $this->swap->id,
        [
            'id' => $this->swap->id,
            'name' => 'New Swap Name',
            'category' => 'vegetable',
            'image' => 'new-image.jpg',
            'imageFile' => UploadedFile::fake()->image('new-image.jpg')
        ]);

    $response->assertStatus(403);
});

test('cannot update swap as guest', function () {
    $response = $this->putJson('/admin/swap/' . $this->swap->id,
        [
            'id' => $this->swap->id,
            'name' => 'New Swap Name',
            'category' => 'vegetable',
            'image' => 'new-image.jpg',
            'imageFile' => UploadedFile::fake()->image('new-image.jpg')
        ]);

    $response->assertStatus(403);
});

test('cannot update swap with invalid id', function () {
    $response = $this->actingAs($this->admin)->putJson('/admin/swap/0',
        [
            'id' => 0,
            'name' => 'New Swap Name',
            'category' => 'vegetable',
            'image' => 'new-image.jpg',
            'imageFile' => UploadedFile::fake()->image('new-image.jpg')
        ]);

    $response->assertStatus(404);
});

test('cannot update swap with invalid image', function () {
    $response = $this->actingAs($this->admin)->putJson('/admin/swap/' . $this->swap->id,
        [
            'id' => $this->swap->id,
            'name' => 'New Swap Name',
            'category' => 'vegetable',
            'image' => 'new-image.jpg',
            'imageFile' => UploadedFile::fake()->create('new-image.pdf', 0)
        ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['imageFile']);
});
