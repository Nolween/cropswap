<?php

namespace Database\Factories;

use App\Models\Crop;
use App\Models\CropSwap;
use App\Models\Swap;
use Illuminate\Database\Eloquent\Factories\Factory;

class CropSwapFactory extends Factory
{
    public function definition(): array
    {
        $cropId = null;
        $swapId = null;

        // Keep generating crop_id and swap_id until unique ones are found
        do {
            $cropId = Crop::inRandomOrder()->first()->id;
            $swapId = Swap::inRandomOrder()->first()->id;
        } while (CropSwap::where('crop_id', $cropId)->where('swap_id', $swapId)->exists());

        return [
            'crop_id'  => $cropId,
            'swap_id'  => $swapId,
            'quantity' => $this->faker->randomElement(CropSwap::QUANTITIES)
        ];
    }
}
