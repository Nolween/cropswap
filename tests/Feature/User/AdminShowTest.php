<?php

use App\Models\Crop;
use App\Models\User;
use App\Models\UserMessage;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->user = User::factory()->create(['role' => 'user']);
    User::factory()->count(10)->create();
    $this->users = User::all();
    $this->repportedMessages = UserMessage::factory()->count(10)->create(
        ['sender_id' => $this->user->id, 'is_reported' => 1]
    );
    $this->crop = Crop::factory()->create(['user_id' => $this->user->id]);
});

test('shows user in admin', function () {
    $response = $this->actingAs($this->admin)->get('/admin/users/' . $this->user->id);

    $response->assertStatus(200);
    $response->assertInertia(fn(AssertableInertia $page) => $page
        ->component('Admin/User/Show')
        ->where('title', 'Admin User Show')
        ->has('crop', count($this->user->crop), function ($crops) {
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
        ->has('reportedMessages', 10)
        ->where('admin_id', $this->admin->id)
    );
});

test('cannot access to user show as user', function () {
    $response = $this->actingAs($this->user)->get('/admin/users/' . $this->user->id);

    $response->assertStatus(403);
});

test('cannot access to user show as guest', function () {
    $response = $this->get('/admin/users/' . $this->user->id);

    $response->assertStatus(403);
});
