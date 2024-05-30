<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Idea;
use App\Models\User;
use App\Models\Vote;
use App\Models\Status;
use App\Models\Category;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VoteIndexPageTest extends TestCase
{

    use RefreshDatabase;

    #[Test]
    public function index_page_contains_idea_index_livewire_component()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['name' => 'Category 1']);
        $statusOpen = Status::factory()->create(['name' => 'Open']);

        $idea = Idea::factory()->create([
            'category_id' => $category->id,
            'status_id' => $statusOpen->id,
            'user_id' => $user->id,
            'title' => 'My first idea',
            'description' => 'My first description'
        ]);

        $this->get(route('idea.index', $idea))
            ->assertSeeLivewire('idea-index');

    }

    #[Test]
    public function index_page_correctly_receives_votes_count()
    {
        $user = User::factory()->create();
        $userB = User::factory()->create();
        $category = Category::factory()->create(['name' => 'Category 1']);
        $statusOpen = Status::factory()->create(['name' => 'Open']);

        $idea = Idea::factory()->create([
            'category_id' => $category->id,
            'status_id' => $statusOpen->id,
            'user_id' => $user->id,
            'title' => 'My first idea',
            'description' => 'My first description'
        ]);

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id
        ]);

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $userB->id
        ]);

        $this->get(route('idea.index'))
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->first()->votes_count == 2;
            });
    }
}
