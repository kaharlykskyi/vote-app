<?php

namespace Database\Seeders;

use App\Models\Idea;
use App\Models\User;
use App\Models\Vote;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Status;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $userCount = 299;
        $ideaCount = 1000;
        $commentCountMax = 50;

        User::factory()->create([
            'name' => 'Mike',
            'email' => 'mishakagar@gmail.com',
            'password' => bcrypt('1234'),
        ]);

        User::factory($userCount)->create();

        Category::factory()->create(['name' => 'Laravel']);
        Category::factory()->create(['name' => 'PHP']);
        Category::factory()->create(['name' => 'JavaScript']);
        Category::factory()->create(['name' => 'MySQL']);

        Status::factory()->create(['name' => 'Open']);
        Status::factory()->create(['name' => 'Considering']);
        Status::factory()->create(['name' => 'In Progress']);
        Status::factory()->create(['name' => 'Implemented']);
        Status::factory()->create(['name' => 'Closed']);

        Idea::factory($ideaCount)->existing()->create();

        foreach (Idea::all() as $idea) {
            $shouldAddVotes = rand(0, 1);
            if($shouldAddVotes) {
                $maxUsers = rand(1, $userCount + 1);
                foreach (range(1, $maxUsers) as $user_id) {
                    Vote::factory()->create([
                        'user_id' => $user_id,
                        'idea_id' => $idea->id,
                    ]);
                }
            }

            $shouldAddComments = rand(0, 1);
            if($shouldAddComments) {
                $commentCount = rand(0, $commentCountMax);
                $comments = Comment::factory($commentCount)->existing()->create(['idea_id' => $idea->id]);

                foreach ($comments as $comment) {
                    $shouldAddCommentLike = rand(0, 1);
                    if ($shouldAddCommentLike) {
                        $maxUsers = rand(1, 20);
                        foreach (range(1, $maxUsers) as $user_id) {
                            Like::factory()->create([
                                'user_id' => $user_id,
                                'comment_id' => $comment->id,
                            ]);
                        }
                    }
                }
            }

        }
    }
}
