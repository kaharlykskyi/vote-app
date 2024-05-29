<?php

namespace Tests\Feature;

use App\Models\Idea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_list_of_ideas_shows_on_main_page()
    {
        $ideaOne = Idea::factory()->create([
            'title' => 'My first idea',
            'description' => 'My first description'
        ]);
        $ideaTwo = Idea::factory()->create([
            'title' => 'My second idea',
            'description' => 'My second description'
        ]);

        $response = $this->get(route("idea.index"));

        $response->assertSuccessful();
        $response->assertSee($ideaOne->title);
        $response->assertSee($ideaOne->description);
        $response->assertSee($ideaTwo->title);
        $response->assertSee($ideaTwo->description);
    }

    #[Test]
    public function single_idea_shows_correctly_on_the_show_page()
    {
        $idea = Idea::factory()->create([
            'title' => 'My first idea',
            'description' => 'My first description'
        ]);

        $response = $this->get(route("idea.show", $idea));

        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
    }

    #[Test]
    public function idea_pagination_works()
    {
        Idea::factory(Idea::PAGINATION_COUNT + 1)->create();

        $ideaOne = Idea::find(1);
        $ideaOne->title = 'My first idea';
        $ideaOne->save();

        $ideaEleven = Idea::find(Idea::PAGINATION_COUNT + 1);
        $ideaEleven->title = 'My eleventh idea';
        $ideaEleven->save();

        $response = $this->get('/');

        $response->assertSuccessful();
        $response->assertSee($ideaOne->title);
        $response->assertDontSee($ideaEleven->title);

        $response = $this->get('/?page=2');
        $response->assertSuccessful();
        $response->assertSee($ideaEleven->title);
        $response->assertDontSee($ideaOne->title);
    }

    #[Test]
    public function same_idea_title_different_slugs()
    {
        $ideaOne = Idea::factory()->create([
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaTwo = Idea::factory()->create([
            'title' => 'My First Idea',
            'description' => 'Another Description for my first idea',
        ]);

        $response = $this->get(route('idea.show', $ideaOne));

        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/my-first-idea');

        $response = $this->get(route('idea.show', $ideaTwo));

        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/my-first-idea-2');
    }
}
