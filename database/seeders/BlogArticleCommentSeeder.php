<?php

namespace Database\Seeders;

use App\Models\BlogArticleComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogArticleCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogArticleComment::factory()
            ->count(50)
            ->create();
    }
}
