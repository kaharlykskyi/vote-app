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

    #[Test]
    public function user_who_is_not_logged_in_is_redirected_to_login_page_when_trying_to_vote()
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
                'votesCount' => 0
            ])
            ->call('vote')
            ->assertRedirect(route('login'));
    }

    #[Test]
    public function user_who_is_logged_in_can_vote()
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

        $this->assertDatabaseMissing('votes', [
            'idea_id' => $idea->id,
            'user_id' => $user->id
        ]);

        Livewire::actingAs($user)
            ->test(IdeaShow::class, [
                'idea' => $idea,
                'votesCount' => 0
            ])
            ->call('vote')
            ->assertSet('votesCount', 1)
            ->assertSet('hasVoted', true)
            ->assertSee('Voted');

        $this->assertDatabaseHas('votes', [
            'idea_id' => $idea->id,
            'user_id' => $user->id
        ]);
    }

    #[Test]
    public function user_who_is_logged_in_can_remove_vote()
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

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id
        ]);

        $this->assertDatabaseHas('votes', [
            'idea_id' => $idea->id,
            'user_id' => $user->id
        ]);

        Livewire::actingAs($user)
            ->test(IdeaShow::class, [
                'idea' => $idea,
                'votesCount' => 1
            ])
            ->call('vote')
            ->assertSet('votesCount', 0)
            ->assertSet('hasVoted', false)
            ->assertSee('Vote');

        $this->assertDatabaseMissing('votes', [
            'idea_id' => $idea->id,
            'user_id' => $user->id
        ]);
    }
}
