<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Idea;
use App\Models\User;
use App\Models\Status;
use App\Models\Category;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_list_of_ideas_shows_on_main_page()
    {
        $user = User::factory()->create();
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);
        $ideaOne = Idea::factory()->create([
            'category_id' => $categoryOne->id,
            'status_id' => Status::factory()->create(),
            'user_id' => $user->id,
            'title' => 'My first idea',
            'description' => 'My first description'
        ]);
        $ideaTwo = Idea::factory()->create([
            'title' => 'My second idea',
            'category_id' => $categoryTwo->id,
            'user_id' => $user->id,
            'status_id' => Status::factory()->create(),
            'description' => 'My second description'
        ]);

        $response = $this->get(route("idea.index"));

        $response->assertSuccessful();
        $response->assertSee($ideaOne->title);
        $response->assertSee($ideaOne->description);
        $response->assertSee($categoryOne->name);
        $response->assertSee($ideaTwo->title);
        $response->assertSee($ideaTwo->description);
        $response->assertSee($categoryTwo->name);
    }

    #[Test]
    public function single_idea_shows_correctly_on_the_show_page()
    {
        $category = Category::factory()->create(['name' => 'Category 1']);
        $user = User::factory()->create();
        $idea = Idea::factory()->create([
            'title' => 'My first idea',
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status_id' => Status::factory()->create(),
            'description' => 'My first description'
        ]);

        $response = $this->get(route("idea.show", $idea));

        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($category->name);
    }

    #[Test]
    public function idea_pagination_works()
    {
        $user = User::factory()->create();

        $idea = Idea::factory()->create();
        
        Idea::factory($idea->getPerPage() + 1)->create([
            'category_id' => Category::factory()->create(),
            'user_id' => $user->id,
            'status_id' => Status::factory()->create()
        ]);

        $ideaOne = Idea::find(1);
        $ideaOne->title = 'My first idea';
        $ideaOne->save();

        $ideaEleven = Idea::find($idea->getPerPage() + 1);
        $ideaEleven->title = 'My eleventh idea';
        $ideaEleven->save();

        $response = $this->get('/');

        $response->assertSuccessful();
        $response->assertSee($ideaEleven->title);
        $response->assertDontSee($ideaOne->title);

        $response = $this->get('/?page=2');
        $response->assertSuccessful();
        $response->assertSee($ideaOne->title);
        $response->assertDontSee($ideaEleven->title);
    }

    #[Test]
    public function same_idea_title_different_slugs()
    {
        $user = User::factory()->create();
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $ideaOne = Idea::factory()->create([
            'title' => 'My First Idea',
            'category_id' => $categoryOne->id,
            'user_id' => $user->id,
            'description' => 'Description for my first idea',
            'status_id' => Status::factory()->create(),
        ]);

        $ideaTwo = Idea::factory()->create([
            'title' => 'My First Idea',
            'category_id' => $categoryTwo->id,
            'user_id' => $user->id,
            'description' => 'Another Description for my first idea',
            'status_id' => Status::factory()->create(),
        ]);

        $response = $this->get(route('idea.show', $ideaOne));

        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/my-first-idea');

        $response = $this->get(route('idea.show', $ideaTwo));

        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/my-first-idea-2');
    }
}
