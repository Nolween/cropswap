<?php

use App\Models\Swap;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->swap = Swap::factory()->create();
});

test('delete swap', function () {
    $response = $this->actingAs($this->admin)->deleteJson('/admin/swap/' . $this->swap->id);

    $response->assertStatus(200);

    expect($response->json('success'))->toBeTrue();
    expect(Swap::find($this->swap->id))->toBeNull();
});

test('cannot delete swap as user', function () {
    $response = $this->actingAs($this->user)->deleteJson('/admin/swap/' . $this->swap->id);

    $response->assertStatus(403);
});

test('cannot delete swap as guest', function () {
    $response = $this->deleteJson('/admin/swap/' . $this->swap->id);

    $response->assertStatus(403);
});

test('cannot delete swap with invalid id', function () {
    $response = $this->actingAs($this->admin)->deleteJson('/admin/swap/1000');

    $response->assertStatus(404);
});

