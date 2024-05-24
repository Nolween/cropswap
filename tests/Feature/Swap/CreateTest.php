<?php

use App\Enums\SwapCategoryEnum;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->categories = SwapCategoryEnum::allTranslated();
});

test('access to the swap form creation', function () {
    $response = $this->actingAs($this->admin)->get('/admin/swap/create');

    $response->assertInertia(function (AssertableInertia $page) {
        $page->component('Admin/Swap/Create');
        $page->has('swap', function (AssertableInertia $page) {
            $page->has('id');
            $page->has('name');
            $page->has('image');
            $page->has('category');
        });
        $page->has('categories');
    });

    $response->assertStatus(200);
});

test('cannot access to the swap form creation as user', function () {
    $response = $this->actingAs($this->user)->get('/admin/swap/create');

    $response->assertStatus(403);
});

test('cannot access to the swap form creation as guest', function () {
    $response = $this->get('/admin/swap/create');

    $response->assertStatus(403);
});
