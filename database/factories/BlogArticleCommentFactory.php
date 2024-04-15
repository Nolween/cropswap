<?php

namespace Database\Factories;

use App\Models\BlogArticle;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogArticleComment>
 */
class BlogArticleCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'blog_article_id' => BlogArticle::inRandomOrder()->first()->id,
            'content'         => $this->faker->sentences(3, true),
            'user_id'         => User::inRandomOrder()->first()->id,
            'created_at'      => $this->faker->dateTimeThisYear,
            'updated_at'      => $this->faker->dateTimeThisMonth,
        ];
    }
}
