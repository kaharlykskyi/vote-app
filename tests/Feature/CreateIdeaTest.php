<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{User, Category, Status};
use Livewire\Livewire;
use App\Livewire\CreateIdea;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateIdeaTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function create_idea_form_does_not_shown_when_logget_out()
    {
        $response = $this->get(route('idea.index'));
        $response->assertSuccessful();
        $response->assertSee('Please log in to create an idea');
        $response->assertDontSee('Let us know what you would like and we\'ll take a look over!');
    }

    #[Test]
    public function create_idea_form_does_shown_when_logget_out()
    {
        $response = $this->actingAs(User::factory()->create())->get(route('idea.index'));
        $response->assertSuccessful();
        $response->assertDontSee('Please log in to create an idea');
        $response->assertSee('Let us know what you would like and we\'ll take a look over!', false);
    }

    #[Test]
    public function main_page_contains_create_idea_livewire_component()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('idea.index'))
            ->assertSeeLivewire('create-idea');
    }

    #[Test]
    public function create_idea_form_validation_works()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateIdea::class)
            ->set('title', '')
            ->set('description', '')
            ->set('category', '')
            ->call('createIdea')
            ->assertHasErrors(['title', 'description', 'category'])
            ->assertSee('The title field is required');
    }

    #[Test]
    public function creating_an_idea_works_correctly()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['name' => 'Category 1']);
        $statusOpen = Status::factory()->create(['name' => 'Open']);

        Livewire::actingAs($user)
            ->test(CreateIdea::class)
            ->set('title', 'My first idea')
            ->set('description', 'My first description')
            ->set('category', $category->id)
            ->call('createIdea')
            ->assertRedirect('/');

        $response = $this->actingAs($user)->get(route('idea.index'));
        $response->assertSuccessful();
        $response->assertSee('My first idea');
        $response->assertSee('Category 1');
        $response->assertSee('0 Comments');

        $this->assertDatabaseHas('ideas', [
            'title' => 'My first idea',
            'description' => 'My first description',
            'category_id' => $category->id,
            'status_id' => $statusOpen->id
        ]);
    }
}
