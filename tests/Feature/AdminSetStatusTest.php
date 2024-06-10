<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Idea;
use App\Models\User;
use App\Models\Status;
use Livewire\Livewire;
use App\Models\Comment;
use App\Models\Category;
use App\Livewire\SetStatus;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminSetStatusTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function show_page_contains_set_status_livewire_component_when_user_is_admin()
    {
        $user = User::factory()->create([
            'email' => 'mishakagar@gmail.com',
        ]);

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire('set-status');
    }

    #[Test]
    public function show_page_does_notcontain_set_status_livewire_component_when_user_is_not_admin()
    {
        $user = User::factory()->create([
            'email' => 'user@user.com',
        ]);

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertDontSeeLivewire('set-status');
    }

    #[Test]
    public function initial_status_is_set_correctly()
    {
        $user = User::factory()->create([
            'email' => 'andre_madarang@hotmail.com',
        ]);

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusConsidering = Status::factory()->create(['id' => 2, 'name' => 'Considering']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusConsidering->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        Livewire::actingAs($user)
            ->test(SetStatus::class, [
                'idea' => $idea,
            ])
            ->assertSet('status', $statusConsidering->id);
    }

    #[Test]
    public function can_set_status_correctly_no_comment()
    {
        $user = User::factory()->admin()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusConsidering = Status::factory()->create(['id' => 2, 'name' => 'Considering']);
        $statusInProgress = Status::factory()->create(['id' => 3, 'name' => 'In Progress']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusConsidering->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        Livewire::actingAs($user)
            ->test(SetStatus::class, [
                'idea' => $idea,
            ])
            ->set('status', $statusInProgress->id)
            ->call('setStatus')
            ->assertDispatched('status-was-updated');

        $this->assertDatabaseHas('ideas', [
            'id' => $idea->id,
            'status_id' => $statusInProgress->id,
        ]);

        $this->assertDatabaseHas('comments', [
            'body' => Comment::EMPTY_UPDATE_STATUS_MESSAGE,
            'is_status_update' => true,
        ]);
    }

    public function can_set_status_correctly_with_comment()
    {
        $user = User::factory()->admin()->create();

        $statusConsidering = Status::factory()->create(['id' => 2, 'name' => 'Considering']);
        $statusInProgress = Status::factory()->create(['id' => 3, 'name' => 'In Progress']);

        $idea = Idea::factory()->create([
            'status_id' => $statusConsidering->id,
        ]);

        Livewire::actingAs($user)
            ->test(SetStatus::class, [
                'idea' => $idea,
            ])
            ->set('status', $statusInProgress->id)
            ->set('comment', 'This is a comment when setting a status')
            ->call('setStatus')
            ->assertDispatched('status-was-updated');

        $this->assertDatabaseHas('ideas', [
            'id' => $idea->id,
            'status_id' => $statusInProgress->id,
        ]);

        $this->assertDatabaseHas('comments', [
            'body' => 'This is a comment when setting a status',
            'is_status_update' => true,
        ]);
    }
}
