<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->user = User::factory()->create(['role' => 'user']);
    User::factory()->count(10)->create();
    $this->users = User::all();
});

test('update user informations', function () {
    $response = $this->actingAs($this->user)->putJson('/account/informations', [
            'name'            => 'John Doe',
            'newMail'         => 'john@doe.com',
            'oldPassword'     => 'password',
            'newPassword'     => 'newpassword',
            'confirmPassword' => 'newpassword',
            'userId'          => $this->user->id,
            'image'           => 'image.jpg',
            'imageFile'       => UploadedFile::fake()->image('image.jpg'),
        ]
    );
    $response->assertStatus(200);
    expect($response->json('success'))->toBeTrue()
                                      ->and($this->user->fresh()->name)->toBe('John Doe')
                                      ->and($this->user->fresh()->email)->toBe('john@doe.com')
                                      ->and(password_verify('newpassword', $this->user->fresh()->password))->toBeTrue();
});

test('cannot update user informations as guest', function () {
    $response = $this->putJson('/account/informations', [
            'name'            => 'John Doe',
            'newMail'         => 'john@doe.com',
            'oldPassword'     => 'password',
            'newPassword'     => 'newpassword',
            'confirmPassword' => 'newpassword',
            'userId'          => $this->user->id,
            'image'           => 'image.jpg',
            'imageFile'       => UploadedFile::fake()->image('image.jpg'),
        ]
    );

    $response->assertStatus(401);
});

test('cannot update user informations with wrong informations', function () {
    $response = $this->actingAs($this->user)->putJson('/account/informations', [
            'name'            => 'AA',
            'newMail'         => 'falsemail',
            'oldPassword'     => 'wrongPassword',
            'newPassword'     => 'pass1',
            'confirmPassword' => 'pass2',
            'userId'          => 0,
            'image'           => 'image.jpg',
            'imageFile'       => 'test',
        ]
    );

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['name', 'newMail', 'oldPassword', 'newPassword', 'confirmPassword', 'userId', 'imageFile']);
});


test('cannot update user as guest', function () {
    $response = $this->putJson('/account/informations', [
        'name'            => 'John Doe',
        'newMail'         => 'john@doe.com',
        'oldPassword'     => 'password',
        'newPassword'     => 'newpassword',
        'confirmPassword' => 'newpassword',
        'userId'          => $this->user->id,
        'image'           => 'image.jpg',
        'imageFile'       => UploadedFile::fake()->image('image.jpg'),
    ]);

    $response->assertStatus(401);
});

