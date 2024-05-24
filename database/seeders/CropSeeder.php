<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Foreach all users and create a crop for each user
        $users = User::all();
        foreach ($users as $user) {
           $crop =  Crop::factory()
                ->create([
                    'user_id' => $user->id,
                ]);
        }
        // $crops = Crop::factory()->count(10)->create();
    }
}
