<?php

namespace Database\Seeders;

use App\Models\UserMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 100 user messages quietly, without firing model events
        UserMessage::factory()->count(100)->make()->each(function ($userMessage) {
            $userMessage->saveQuietly();
        });
    }
}
