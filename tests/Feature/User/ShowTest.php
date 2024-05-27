<?php

use App\Models\Crop;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    User::factory()->count(10)->create();
    $this->users = User::all();
    $this->crop = Crop::factory()->create(['user_id' => $this->user->id]);
});

test('show user informations account', function () {
    $response = $this->actingAs($this->user)->get('/account/informations');

    $response->assertStatus(200);

    $response->assertInertia(fn (AssertableInertia $page) =>
        $page
            ->component('Account/Informations')
            ->has('user', function ($user) {
                $user
                    ->has('id')
                    ->has('name')
                    ->has('email')
                    ->has('role')
                    ->has('image')
                    ->has('email_verified_at')
                    ->has('created_at')
                    ->has('updated_at')
                    ->etc();

            })
            ->has('crops', 1, function ($crops) {
                $crops
                    ->has('id')
                    ->has('name')
                    ->has('description')
                    ->has('image')
                    ->has('user_id')
                    ->has('created_at')
                    ->has('updated_at')
                    ->etc();
            })
    );
});

test('cannot access to user informations account as guest', function () {
    $response = $this->get('/account/informations');

    $response->assertStatus(302);
    $response->assertRedirect('/login');
});

