<?php

namespace Tests\Feature;

use App\Livewire\IdeaShow;
use Tests\TestCase;
use App\Models\Idea;
use App\Models\User;
use App\Models\Vote;
use App\Models\Status;
use App\Models\Category;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class VoteShowPageTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function show_page_contains_idea_show_livewire_component()
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

        $this->get(route('idea.show', $idea))->assertSeeLivewire('idea-show');
    }

    #[Test]
    public function show_page_correctly_receives_votes_count()
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

        $this->get(route('idea.show', $idea))
            ->assertViewHas('votesCount', 2);
    }

    #[Test]
    public function votes_count_shows_correctly_on_show_page_livewire_component()
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

        Livewire::test(IdeaShow::class, [
                'idea' => $idea,
                'votesCount' => 2
            ])
            ->assertSet('votesCount', 2);
    }
}
