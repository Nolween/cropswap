<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserMessage>
 */
class UserMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Random existing sender ID
        $sender = User::inRandomOrder()->first();
        // Random existing receiver ID (not the same as sender)
        $receiver = User::where('id', '!=', $sender->id)->inRandomOrder()->first();

        $created = $this->faker->dateTimeBetween('-1 year', 'now');

        $read = $this->faker->boolean(50);

        return [
            'sender_id'   => $sender->id,
            'receiver_id' => $receiver->id,
            'content'     => $this->faker->sentences(3, true),
            'read'        => $read,
            'read_at'     => $read ? $this->faker->dateTimeBetween($created, 'now') : null,
            'is_reported' => $this->faker->boolean(5),
            'created_at'  => $created,
            'updated_at'  => $this->faker->dateTimeBetween($created, 'now'),
        ];
    }
}
