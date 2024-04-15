<?php

namespace Database\Factories;

use App\Models\Crop;
use App\Models\CropSwap;
use App\Models\Swap;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CropSwapFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $cropId = Crop::inRandomOrder()->first()->id;
        $swapId = Swap::inRandomOrder()->first()->id;

        // If there is already a crop swap with the same crop and swap, return an empty array
        if (CropSwap::where('crop_id', $cropId)->where('swap_id', $swapId)->exists()) {
            return [];
        }

        return [
            'crop_id'  => $cropId,
            'swap_id'  => $swapId,
            'quantity' => $this->faker->randomElement(CropSwap::QUANTITIES)
        ];
    }
}
