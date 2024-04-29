<?php

namespace Database\Seeders;

use App\Models\Swap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SwapSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Foreach all food images in the public/images/food directory
        foreach (glob(public_path('images/food/*')) as $image) {
            // Create a new swap
            $swap = new Swap();
            // Set the name to the filename of the image, removing _ and .svg and capitalizing the first letter
            $swap->name = ucfirst(str_replace('_', ' ', pathinfo($image, PATHINFO_FILENAME)));
            // Set the image to the path of the image
            $swap->image = basename($image);
            // Set the category to food
            $swap->category = null;
            // Save the swap
            $swap->save();
        }
    }
}
