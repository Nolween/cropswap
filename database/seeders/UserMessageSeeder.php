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
    //    Create 100 user messages
        UserMessage::factory(100)->create();
    }
}
