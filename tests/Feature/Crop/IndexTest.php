<?php

use App\Models\Crop;
use App\Models\Swap;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->swaps = Swap::factory()->count(rand(30, 50))->create();
    $this->crops = Crop::factory()->count(rand(1, 10))->create();

});

test('show the crops index', function () {
    $response = $this->get('/crop');

    $response->assertInertia(function (AssertableInertia $page) {
        $page->component('Crop/Index');
        $page->has('markers');
        // Crops have the following keys: id, name, date, user_id, image, author, comments, tags
        $crops = $page->toArray()['props']['markers'];

        // Expect the crops have the correct keys and correct number of crops
        expect(count($crops))->toBe(count($this->crops));

        $page->has('markers', count($this->crops), fn (AssertableInertia $page) => $page
            ->has('id')
            ->has('icon')
            ->has('position')
            ->has('swaps')
            ->has('name')
            ->has('description')
        );

        $swaps = $page->toArray()['props']['swaps'];
         expect(count($swaps))->toBe(count($this->swaps));

    });

    $response->assertStatus(200);
});
