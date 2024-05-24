<?php

use App\Models\Crop;
use App\Models\CropSwap;
use App\Models\Swap;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->crop = Crop::factory()->create();
    $this->swaps = Swap::factory()->count(rand(5, 10))->create();
    generateCropSwaps(2, 10);
});

test('can access to its crop informations', function () {
    $response = $this->actingAs($this->user)->get('/account/crop');

    $response->assertInertia(fn(AssertableInertia $page) => $page
        ->component('Account/Crop')
        ->has('crop', fn(AssertableInertia $page) => $page
            ->where('id', $this->crop->id)
            ->where('name', $this->crop->name)
            ->where('description', $this->crop->description)
            ->where('image', $this->crop->image)
            ->where('user_id', $this->crop->user_id)
            ->etc()
        )
        ->has('user')
        ->has('swaps')
        ->where('swapList', Swap::all(), fn(AssertableInertia $page) => $page
            ->has('id')
            ->has('crop_id')
            ->has('user_id')
            ->has('name')
            ->has('description')
            ->has('image')
            ->has('created_at')
            ->has('updated_at')
            ->has('deleted_at')
            ->etc()
        )
        ->etc()
    );

    $response->assertStatus(200);
});

test('cannot access to crop informations as guest and is redirect', function () {
    $response = $this->get('/account/crop');

    $response->assertStatus(302);

    $response->assertRedirect('/login');
});
