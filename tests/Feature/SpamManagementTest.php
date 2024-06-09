<?php

namespace Tests\Feature;

use App\Livewire\IdeaIndex;
use App\Livewire\IdeaShow;
use App\Livewire\MarkIdeaAsNotSpam;
use App\Livewire\MarkIdeaAsSpam;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Http\Response;
use Livewire\Livewire;
use Tests\TestCase;

class SpamManagementTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function shows_mark_idea_as_spam_livewire_component_when_user_has_authorization()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire('mark-idea-as-spam');
    }

    #[Test]
    public function does_not_show_mark_idea_as_spam_livewire_component_when_user_does_not_have_authorization()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $this->get(route('idea.show', $idea))
            ->assertDontSeeLivewire('mark-idea-as-spam');
    }

    #[Test]
    public function marking_an_idea_as_spam_works_when_user_has_authorization()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        Livewire::actingAs($user)
            ->test(MarkIdeaAsSpam::class, [
                'idea' => $idea,
            ])
            ->call('markAsSpam')
            ->assertDispatched('idea-was-marked-as-spam');

        $this->assertEquals(1, Idea::first()->spam_reports);
    }

    #[Test]
    public function marking_an_idea_as_spam_does_not_work_when_user_does_not_have_authorization()
    {
        $idea = Idea::factory()->create();

        Livewire::test(MarkIdeaAsSpam::class, [
                'idea' => $idea,
            ])
            ->call('markAsSpam')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    #[Test]
    public function marking_an_idea_as_spam_shows_on_menu_when_user_has_authorization()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        Livewire::actingAs($user)
            ->test(IdeaShow::class, [
                'idea' => $idea,
                'votesCount' => 4,
            ])
            ->assertSee('Mark as Spam');
    }

    #[Test]
    public function marking_an_idea_as_spam_does_not_show_on_menu_when_user_does_not_have_authorization()
    {
        $idea = Idea::factory()->create();

        Livewire::test(IdeaShow::class, [
                'idea' => $idea,
                'votesCount' => 4,
            ])
            ->assertDontSee('Mark as Spam');
    }

    #[Test]
    public function shows_mark_idea_as_not_spam_livewire_component_when_user_has_authorization()
    {
        $user = User::factory()->admin()->create();
        $idea = Idea::factory()->create();

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire('mark-idea-as-not-spam');
    }

    #[Test]
    public function does_not_show_mark_idea_as_not_spam_livewire_component_when_user_does_not_have_authorization()
    {
        $idea = Idea::factory()->create();

        $this->get(route('idea.show', $idea))
            ->assertDontSeeLivewire('mark-idea-as-not-spam');
    }

    #[Test]
    public function marking_an_idea_as_not_spam_works_when_user_has_authorization()
    {
        $user = User::factory()->admin()->create();
        $idea = Idea::factory()->create([
            'spam_reports' => 4,
        ]);

        Livewire::actingAs($user)
            ->test(MarkIdeaAsNotSpam::class, [
                'idea' => $idea,
            ])
            ->call('markAsNotSpam')
            ->assertDispatched('idea-was-marked-as-not-spam');

        $this->assertEquals(0, Idea::first()->spam_reports);
    }

    #[Test]
    public function marking_an_idea_as_not_spam_does_not_work_when_user_does_not_have_authorization()
    {
        $idea = Idea::factory()->create();

        Livewire::test(MarkIdeaAsNotSpam::class, [
                'idea' => $idea,
            ])
            ->call('markAsNotSpam')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    #[Test]
    public function marking_an_idea_as_not_spam_shows_on_menu_when_user_has_authorization()
    {
        $user = User::factory()->admin()->create();
        $idea = Idea::factory()->create([
            'spam_reports' => 1,
        ]);

        Livewire::actingAs($user)
            ->test(IdeaShow::class, [
                'idea' => $idea,
                'votesCount' => 4,
            ])
            ->assertSee('Not Spam');
    }

    #[Test]
    public function marking_an_idea_as_not_spam_does_not_show_on_menu_when_user_does_not_have_authorization()
    {
        $idea = Idea::factory()->create();

        Livewire::test(IdeaShow::class, [
                'idea' => $idea,
                'votesCount' => 4,
            ])
            ->assertDontSee('Not Spam');
    }

    #[Test]
    public function spam_reports_count_shows_on_idea_index_page_if_logged_in_as_admin()
    {
        $user = User::factory()->admin()->create();
        $idea = Idea::factory()->create([
            'spam_reports' => 3,
        ]);

        Livewire::actingAs($user)
            ->test(IdeaIndex::class, [
                'idea' => $idea,
                'votesCount' => 4,
            ])
            ->assertSee('Spam Reports: 3');
    }

    #[Test]
    public function spam_reports_count_shows_on_idea_show_page_if_logged_in_as_admin()
    {
        $user = User::factory()->admin()->create();
        $idea = Idea::factory()->create([
            'spam_reports' => 3,
        ]);

        Livewire::actingAs($user)
            ->test(IdeaShow::class, [
                'idea' => $idea,
                'votesCount' => 4,
            ])
            ->assertSee('Spam Reports: 3');
    }
}
