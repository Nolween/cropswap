<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Swap;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //    Launch the UserSeeder
        $this->call(UserSeeder::class);
        //    Launch the SwapSeeder
        $this->call(SwapSeeder::class);
        //    Launch the CropSeeder
        $this->call(CropSeeder::class);
        //    Launch the BlogArticleSeeder
        $this->call(BlogArticleSeeder::class);
        //    Launch the BlogCommentSeeder
        $this->call(BlogArticleCommentSeeder::class);
        //   Launch the CropSwapSeeder
        $this->call(CropSwapSeeder::class);
        //    Launch the UserMessageSeeder
        $this->call(UserMessageSeeder::class);
    }
}
