<?php

namespace Database\Factories;

use App\Enums\SwapCategoryEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Swap>
 */
class SwapFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'     => $this->faker->name,
            'image'    => $this->faker->imageUrl(),
            'category' => $this->faker->randomElement(SwapCategoryEnum::all()),
        ];
    }
}
