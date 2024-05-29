<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Idea;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Category::factory()->count(4)->create();

        Idea::factory()->count(30)->create();
    }
}
