<?php

use App\Models\User;
use App\Models\UserMessage;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->user = User::factory()->create(['role' => 'user']);
    $this->users = User::all();
//  For 3 users which are not the current user, create 100 messages
    User::factory()->count(3)->create()->each(function ($user) {
        UserMessage::factory()->count(10)->create([
            'sender_id' => $user->id,
            'receiver_id' => $this->user->id
        ]);
    });
    $this->messages = UserMessage::all();
});

test('get all conversations of the user', function () {
    $response = $this->actingAs($this->user)->get('/messages');

    $response->assertInertia(fn (AssertableInertia $page) =>
        $page
            ->component('Account/Messages')
            ->where('title', 'Messages Index')
            ->where('authId', $this->user->id)
            ->has('conversations', 3, function ($messages) {
                $messages
                    ->has('user')
                    ->has('last_message')
                    ->has('receiver_id')
                    ->has('messages')
                    ->has('user_image')
                    ->has('conversation_id')
                    ->etc();
            })
    );

    $response->assertStatus(200);
});

test('cannot access to messages as guest', function () {
    $response = $this->get('/messages');

    $response->assertStatus(302);
    $response->assertRedirect('/login');
});
