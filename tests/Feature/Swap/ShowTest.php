<?php

use App\Enums\SwapCategoryEnum;
use App\Models\Swap;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->user = User::factory()->create(['role' => 'user']);
    $this->swap = Swap::factory()->create();
    $this->categories = SwapCategoryEnum::allTranslated();
});

test('access to the swap informations', function () {
    $response = $this->actingAs($this->admin)->get('/admin/swap/' . $this->swap->id);

    $response->assertInertia(fn(AssertableInertia $page) => $page
        ->component('Admin/Swap/Create')
        ->has('swap', fn(AssertableInertia $page) => $page
            ->where('id', $this->swap->id)
            ->where('name', $this->swap->name)
            ->where('category', $this->swap->category)
            ->where('image', $this->swap->image)
            ->etc()
        )
        ->has('categories', count($this->categories))
    );

    $response->assertStatus(200);
});

test('cannot access to the swap informations as user', function () {
    $response = $this->actingAs($this->user)->get('/admin/swap/' . $this->swap->id);

    $response->assertStatus(403);
});

test('cannot access to the swap informations as guest', function () {
    $response = $this->get('/admin/swap/' . $this->swap->id);

    $response->assertStatus(403);
});
