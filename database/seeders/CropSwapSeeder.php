<?php

namespace Database\Seeders;

use App\Models\CropSwap;
use Database\Factories\CropSwapFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CropSwapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Run the CropSeeder and SwapSeeder before creating CropSwap instances
        $this->call(CropSeeder::class);
        $this->call(SwapSeeder::class);

        CropSwap::factory()->count(100)->create();
    }
}
