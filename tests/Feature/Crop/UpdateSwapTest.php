<?php

use App\Models\Crop;
use App\Models\Swap;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->crop = Crop::factory()->create(['user_id' => $this->user->id]);
    $this->swap = Swap::factory()->create();
});

test('add a new crop swap for the user crop', function () {
    $response = $this->actingAs($this->user)->postJson('/account/crop/' . $this->crop->id . '/swap', [
        'swapId'   => $this->swap->id,
        'quantity' => 1,
    ]);

    $response->assertStatus(200);
    expect($response->json('success'))->toBeTrue();
    expect($this->crop->fresh()->swaps->count())->toBe(1);
    expect($this->crop->fresh()->swaps->first()->id)->toBe($this->swap->id);
});

test('update an existing crop swap for the user crop', function () {
    $this->crop->swaps()->attach($this->swap->id, ['quantity' => 1]);

    $response = $this->actingAs($this->user)->postJson('/account/crop/' . $this->crop->id . '/swap', [
        'quantity' => 2,
        'swapId'   => $this->swap->id,
    ]);

    $response->assertStatus(200);
    expect($response->json('success'))->toBeTrue();
    expect($this->crop->fresh()->swaps->first()->pivot->quantity)->toBe(2);
});

test('remove an existing crop swap from user crop', function () {
    $this->crop->swaps()->attach($this->swap->id, ['quantity' => 1]);

    $response = $this->actingAs($this->user)->postJson('/account/crop/' . $this->crop->id . '/swap', [
        'swapId'   => $this->swap->id,
        'quantity' => null,
    ]);

    $response->assertStatus(200);
    expect($response->json('success'))->toBeTrue();
    expect($this->crop->fresh()->swaps->count())->toBe(0);
});


test('cannot add a new crop swap for another user crop', function () {
    $response = $this->actingAs($this->admin)->postJson('/account/crop/' . $this->crop->id . '/swap', [
        'swapId'   => $this->swap->id,
        'quantity' => 1,
    ]);

    $response->assertStatus(403);
});

test('cannot access to an invalid crop', function () {
    $response = $this->actingAs($this->user)->postJson('/account/crop/0/swap', [
        'swapId'   => $this->swap->id,
        'quantity' => 1,
    ]);

    $response->assertStatus(404);
});

test('cannot add a new crop swap for guest', function () {
    $response = $this->postJson('/account/crop/' . $this->crop->id . '/swap', [
        'swapId'   => $this->swap->id,
        'quantity' => 1,
    ]);

    $response->assertStatus(401);
});

test('cannot update with invalid data', function () {
    $response = $this->actingAs($this->user)->postJson('/account/crop/' . $this->crop->id . '/swap', [
        'swapId'   => 0,
        'quantity' => 'invalid',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['quantity', 'swapId']);
});
