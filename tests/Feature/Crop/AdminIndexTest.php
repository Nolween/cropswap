<?php

use App\Models\Crop;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->crops = Crop::factory()->count(rand(1, 10))->create();
});

test('example', function () {
    $response = $this->actingAs($this->admin)->get('/admin/crop/index');

    $response->assertInertia(function (AssertableInertia $page) {
        $page->component('Admin/Crop/Index');
        $page->has('crops');
        // Crops have the following keys: id, name, date, user_id, image, author, comments, tags
        $crops = $page->toArray()['props']['crops'];

        // Expect the crops have the correct keys and correct number of crops
        expect(count($crops))->toBe(count($this->crops));

        $page->has('crops', count($this->crops), fn (AssertableInertia $page) => $page
            ->has('id')
            ->has('reports')
            ->has('image')
            ->has('user')
            ->has('userId')
            ->has('name')
        );
    });

    $response->assertStatus(200);
});

test('forbidden access to crop admin index for user', function () {
    $response = $this->actingAs($this->user)->get('/admin/crop/index');

    $response->assertStatus(403);
});

test('forbidden access to crop admin index for guest', function () {
    $response = $this->get('/admin/crop/index');

    $response->assertStatus(403);
});
