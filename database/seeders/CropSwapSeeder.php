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
        CropSwap::factory()->count(100)->create();
    }
}
