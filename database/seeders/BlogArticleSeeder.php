<?php

namespace Database\Seeders;

use App\Models\BlogArticle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogArticle::factory()
            ->count(10)
            ->create();
    }
}
