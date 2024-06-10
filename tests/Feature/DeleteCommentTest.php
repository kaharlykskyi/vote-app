<?php

namespace Tests\Feature\Comments;

use App\Livewire\DeleteComment;
use App\Livewire\IdeaComment;
use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Livewire\Livewire;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class DeleteCommentTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function shows_delete_comment_livewire_component_when_user_has_authorization()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire('delete-comment');
    }

    #[Test]
    public function does_not_show_delete_comment_livewire_component_when_user_does_not_have_authorization()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $this->get(route('idea.show', $idea))
            ->assertDontSeeLivewire('delete-comment');
    }

    #[Test]
    public function delete_comment_is_set_correctly_when_user_clicks_it_from_menu()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::actingAs($user)
            ->test(DeleteComment::class)
            ->call('setDeleteComment', $comment->id)
            ->assertDispatched('delete-comment-was-set');
    }

    #[Test]
    public function deleting_a_comment_works_when_user_has_authorization()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::actingAs($user)
            ->test(DeleteComment::class)
            ->call('setDeleteComment', $comment->id)
            ->call('deleteComment')
            ->assertDispatched('comment-was-deleted');

        $this->assertEquals(0, Comment::count());
    }

    #[Test]
    public function deleting_a_comment_does_not_work_when_user_does_not_have_authorization()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::actingAs($user)
            ->test(DeleteComment::class)
            ->call('setDeleteComment', $comment->id)
            ->call('deleteComment')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    #[Test]
    public function deleting_a_comment_shows_on_menu_when_user_has_authorization()
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
                'ideaUserId' => $idea->user_id,
            ])
            ->assertSee('Delete Comment');
    }

    #[Test]
    public function deleting_a_comment_does_not_show_on_menu_when_user_does_not_have_authorization()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::actingAs($user)
            ->test(IdeaComment::class, [
                'comment' => $comment,
                'ideaUserId' => $idea->user_id,
            ])
            ->assertDontSee('Delete Comment');
    }
}
