<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->receiver = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
});

test('store a new user message user', function () {
    $response = $this->actingAs($this->user)->postJson('/messages', [
        'receiver_id' => $this->receiver->id,
        'sender_id'   => $this->user->id,
        'content'     => 'Hello World'
    ]);

    $response->assertStatus(200);
    expect($response->json('success'))->toBeTrue()
                                      ->and($response->json('message'))->toBe('Message envoyé')
                                      ->and($this->user->sentMessages->count())->toBe(1)
                                      ->and($this->receiver->receivedMessages->count())->toBe(1)
                                      ->and($this->user->sentMessages->first()->content)->toBe('Hello World')
                                      ->and($this->receiver->receivedMessages->first()->content)->toBe('Hello World');
});

test('cannot store a new user message as guest', function () {
    $response = $this->postJson('/messages', [
        'receiver_id' => $this->receiver->id,
        'sender_id'   => $this->user->id,
        'content'     => 'Hello World'
    ]);

    $response->assertStatus(401);
});

test('cannot store a new user message with wrong informations', function () {
    $response = $this->actingAs($this->user)->postJson('/messages', [
        'receiver_id' => 0,
        'sender_id'   => 0,
        'content'     => ''
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['sender_id', 'receiver_id', 'content']);
});
