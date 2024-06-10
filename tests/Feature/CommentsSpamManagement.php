<?php

namespace Tests\Feature\Comments;

use App\Livewire\IdeaComment;
use App\Livewire\MarkCommentAsNotSpam;
use App\Livewire\MarkCommentAsSpam;
use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Livewire\Livewire;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CommentsSpamManagementTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function shows_mark_comment_as_spam_livewire_component_when_user_has_authorization()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
            'body' => 'This is my first comment',
        ]);

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire('mark-comment-as-spam');
    }

    #[Test]
    public function does_not_show_mark_comment_as_spam_livewire_component_when_user_does_not_have_authorization()
    {
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        $this->get(route('idea.show', $idea))
            ->assertDontSeeLivewire('mark-comment-as-spam');
    }

    #[Test]
    public function marking_a_comment_as_spam_works_when_user_has_authorization()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::actingAs($user)
            ->test(MarkCommentAsSpam::class)
            ->call('setMarkAsSpamComment', $comment->id)
            ->call('markAsSpam')
            ->assertDispatched('comment-was-marked-as-spam');

        $this->assertEquals(1, Comment::first()->spam_reports);
    }

    #[Test]
    public function marking_a_comment_as_spam_does_not_work_when_user_does_not_have_authorization()
    {
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::test(MarkCommentAsSpam::class)
            ->call('setMarkAsSpamComment', $comment->id)
            ->call('markAsSpam')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    #[Test]
    public function marking_a_comment_as_spam_shows_on_menu_when_user_has_authorization()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::actingAs($user)
            ->test(IdeaComment::class, [
                'comment' => $comment,
                'ideaUserId' => $idea->user_id
            ])
            ->assertSee('Mark as Spam');
    }

    #[Test]
    public function marking_a_comment_as_spam_does_not_show_on_menu_when_user_does_not_have_authorization()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::test(IdeaComment::class, [
                'comment' => $comment,
                'ideaUserId' => $idea->user_id
            ])
            ->assertDontSee('Mark as Spam');
    }

    #[Test]
    public function shows_mark_comment_as_not_spam_livewire_component_when_user_has_authorization()
    {
        $user = User::factory()->admin()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
            'body' => 'This is my first comment',
        ]);

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire('mark-comment-as-not-spam');
    }

    #[Test]
    public function does_not_show_mark_comment_as_not_spam_livewire_component_when_user_does_not_have_authorization()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertDontSeeLivewire('mark-comment-as-not-spam');
    }

    #[Test]
    public function marking_a_comment_as_not_spam_works_when_user_has_authorization()
    {
        $user = User::factory()->admin()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::actingAs($user)
            ->test(MarkCommentAsNotSpam::class)
            ->call('setMarkAsNotSpamComment', $comment->id)
            ->call('markAsNotSpam')
            ->assertEmitted('commentWasMarkedAsNotSpam');

        $this->assertEquals(0, Comment::first()->spam_reports);
    }

    #[Test]
    public function marking_a_comment_as_not_spam_does_not_work_when_user_does_not_have_authorization()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::actingAs($user)
            ->test(MarkCommentAsNotSpam::class)
            ->call('setMarkAsNotSpamComment', $comment->id)
            ->call('markAsNotSpam')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    #[Test]
    public function marking_a_comment_as_not_spam_shows_on_menu_when_user_has_authorization()
    {
        $user = User::factory()->admin()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
            'spam_reports' => 1,
        ]);

        Livewire::actingAs($user)
            ->test(IdeaComment::class, [
                'comment' => $comment,
                'ideaUserId' => $idea->user_id
            ])
            ->assertSee('Not Spam');
    }

    #[Test]
    public function marking_a_comment_as_not_spam_does_not_show_on_menu_when_user_does_not_have_authorization()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::actingAs($user)
            ->test(IdeaComment::class, [
                'comment' => $comment,
                'ideaUserId' => $idea->user_id
            ])
            ->assertDontSee('Not Spam');
    }
}
