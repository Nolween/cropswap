<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Crop>
 */
class CropFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => $this->faker->sentence,
            'description'       => $this->faker->paragraph,
            'image'             => $this->faker->imageUrl(),
            'user_id'           => User::inRandomOrder()->first()->id,
            'created_at'        => $this->faker->dateTimeThisYear,
            'updated_at'        => $this->faker->dateTimeThisMonth,
            'deleted_at'        => null,
            'latitude'          => $this->faker->latitude,
            'longitude'         => $this->faker->longitude,
            'is_active'         => $this->faker->boolean,
            'is_permaculture'   => $this->faker->boolean,
            'is_shared'         => $this->faker->boolean,
            'is_pesticide_free' => $this->faker->boolean,
            'is_private'        => $this->faker->boolean,
            'is_professional'   => $this->faker->boolean,
            'can_give'          => $this->faker->boolean,
            'can_swap'          => $this->faker->boolean,
            'can_sell'          => $this->faker->boolean,
        ];
    }
}
