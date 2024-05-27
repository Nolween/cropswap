<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    User::factory()->count(10)->create();
    $this->users = User::all();
});

test('access to users index', function () {
    $response = $this->actingAs($this->admin)->get('/admin/users/index');

    $response->assertStatus(200);

    $response->assertInertia(fn (AssertableInertia $page) =>
        $page
            ->component('Admin/User/Index')
            ->where('title', 'Admin User Index')
            ->has('users', count($this->users),  fn ($users) =>
                $users->has('id')
                    ->has('image')
                    ->has('name')
                    ->has('email')
                    ->has('role')
            )
    );
});

test('cannot access to users index as user', function() {
    $response = $this->actingAs($this->user)->get('/admin/users/index');

    $response->assertStatus(403);
});


test('cannot access to users index as guest', function() {
    $response = $this->get('/admin/users/index');

    $response->assertStatus(403);
});
