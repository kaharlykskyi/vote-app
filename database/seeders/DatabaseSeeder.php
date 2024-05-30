<?php

namespace Database\Seeders;

use App\Models\Idea;
use App\Models\User;
use App\Models\Vote;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Status;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Mike',
            'email' => 'mishakagar@gmail.com',
            'password' => bcrypt('1234'),
        ]);

        User::factory()->count(19)->create();

        Category::factory()->count(4)->create();

        Status::factory()->create(['name' => 'Open']);
        Status::factory()->create(['name' => 'Considering']);
        Status::factory()->create(['name' => 'In Progress']);
        Status::factory()->create(['name' => 'Implemented']);
        Status::factory()->create(['name' => 'Closed']);

        Idea::factory()->count(100)->create();

        //generate unique votes, ensure idea_id and user_id are unique for each row
        foreach(range(1, 20) as $user_id) {
            foreach(range(1, 100) as $idea_id) {
                if($idea_id % 2 === 0) {
                    continue;
                }

                Vote::factory()->create([
                    'idea_id' => $idea_id,
                    'user_id' => $user_id,
                ]);
            }
        }
    }
}
