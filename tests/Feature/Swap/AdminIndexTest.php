<?php

use App\Enums\SwapCategoryEnum;
use App\Models\Swap;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->swaps = Swap::factory()->count(rand(1, 10))->create();
    $this->categories = SwapCategoryEnum::allTranslated();
});

test('access to the swaps index', function () {
    $response = $this->actingAs($this->admin)->get('/admin/swap/index');

    $response->assertInertia(function (AssertableInertia $page) {
        $page->component('Admin/Swap/Index');
        $page->has('swaps');
        $page->has('swaps', count($this->swaps), fn(AssertableInertia $page) => $page
            ->has('id')
            ->has('name')
            ->has('image')
            ->has('category')
        );
        // Categories is an array of translated values
        $page->has('categories', count($this->categories));
    });

    $response->assertStatus(200);
});

test('cannot access to the swaps index as user', function () {
    $response = $this->actingAs($this->user)->get('/admin/swap/index');

    $response->assertStatus(403);
});

test('cannot access to the swaps index as guest', function () {
    $response = $this->get('/admin/swap/index');

    $response->assertStatus(403);
});


