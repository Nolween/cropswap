<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Cashandrick',
            'email'    => 'nolween.lopez@gmail.com',
            'password' => bcrypt('12345678'),
            'role'     => 'admin',
        ]);
        User::factory()->count(10)->create();
    }
}
