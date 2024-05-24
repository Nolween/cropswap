<?php

use App\Models\Crop;
use App\Models\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->crop = Crop::factory()->create(['user_id' => $this->user->id]);
});

test('can update crop to its account', function () {
    $response = $this->actingAs($this->user)->putJson('/account/crop/' . $this->crop->id, [
        'name' => 'New Crop Name',
        'description' => 'New Crop Description',
        'image' => 'image.jpg',
        'imageFile' => UploadedFile::fake()->image('image.jpg')
    ]);

    $response->assertStatus(200);
    expect($response->json('success'))->toBeTrue();
    expect($this->crop->fresh()->name)->toBe('New Crop Name');
    expect($this->crop->fresh()->description)->toBe('New Crop Description');
    expect(file_exists(public_path('images/crop/' . $this->crop->fresh()->image)))->toBeTrue();

});

test('cannot update crop to another user account', function () {
    $response = $this->actingAs($this->admin)->putJson('/account/crop/' . $this->crop->id, [
        'name' => 'New Crop Name',
        'description' => 'New Crop Description',
        'image' => 'image.jpg',
        'imageFile' => UploadedFile::fake()->image('image.jpg')
    ]);

    $response->assertStatus(403);
});

test('cannot update crop as guest', function () {
    $response = $this->putJson('/account/crop/' . $this->crop->id, [
        'name' => 'New Crop Name',
        'description' => 'New Crop Description',
        'image' => 'image.jpg',
        'imageFile' => UploadedFile::fake()->image('image.jpg')
    ]);

    $response->assertStatus(401);
});

test('cannot update crop with invalid data', function () {
    $response = $this->actingAs($this->user)->putJson('/account/crop/' . $this->crop->id, [
        'name' => '',
        'description' => '',
        'image' => '',
        'imageFile' => UploadedFile::fake()->image('image.jpg')
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['name', 'description', 'image']);
});
