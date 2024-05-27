<?php

use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->user = User::factory()->create(['role' => 'user']);
    $this->otherUser = User::factory()->create(['role' => 'user']);
});

test('destroy user', function () {
    $response = $this->actingAs($this->admin)->deleteJson('/account/' . $this->user->id);

    $response->assertStatus(200);

    expect($response->json('success'))->toBeTrue()
                                      ->and(User::find($this->user->id))->toBeNull();
});

test('cannot destroy user as an other user', function () {
    $response = $this->actingAs($this->otherUser)->deleteJson('/account/' . $this->user->id);

    $response->assertStatus(403);
    expect($response->json('success'))->toBeFalse()
                                      ->and(User::find($this->user->id))->not->toBeNull();
});

test('cannot destroy user as guest', function () {
    $response = $this->deleteJson('/account/' . $this->user->id);

    $response->assertStatus(401);
    expect(User::find($this->user->id))->not->toBeNull();
});
