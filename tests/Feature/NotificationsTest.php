<?php

namespace Tests\Feature;

use App\Livewire\AddComment;
use App\Livewire\Notifications;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Livewire;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function comment_notifications_livewire_component_renders_when_user_logged_in()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('idea.index'));

        $response->assertSeeLivewire('notifications');
    }

    #[Test]
    public function comment_notifications_livewire_component_does_not_render_when_user_not_logged_in()
    {
        $response = $this->get(route('idea.index'));

        $response->assertDontSeeLivewire('notifications');
    }

    #[Test]
    public function notifications_show_for_logged_in_user()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create([
            'user_id' => $user->id,
        ]);

        $userACommenting = User::factory()->create();
        $userBCommenting = User::factory()->create();

        Livewire::actingAs($userACommenting)
            ->test(AddComment::class, [ 'idea' => $idea, ])
            ->set('body', 'This is the first comment')
            ->call('postComment');

        Livewire::actingAs($userBCommenting)
            ->test(AddComment::class, [ 'idea' => $idea, ])
            ->set('body', 'This is the second comment')
            ->call('postComment');

        DatabaseNotification::first()->update([ 'created_at' => now()->subMinute() ]);

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->call('getNotifications')
            ->assertSeeInOrder(['This is the second comment', 'This is the first comment'])
            ->assertSet('notificationCount', 2);
    }

    #[Test]
    public function notification_count_greater_than_threshold_shows_for_logged_in_user()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create([
            'user_id' => $user->id,
        ]);

        $userACommenting = User::factory()->create();
        $threshold = Notifications::NOTIFICATION_THRESHOLD;

        foreach (range(1, $threshold + 1) as $item) {
            Livewire::actingAs($userACommenting)
                ->test(AddComment::class, [ 'idea' => $idea, ])
                ->set('body', 'This is the first comment')
                ->call('postComment');
        }

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->call('getNotifications')
            ->assertSet('notificationCount', $threshold.'+')
            ->assertSee($threshold.'+');
    }

    #[Test]
    public function can_mark_all_notifications_as_read()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create([
            'user_id' => $user->id,
        ]);

        $userACommenting = User::factory()->create();
        $userBCommenting = User::factory()->create();

        Livewire::actingAs($userACommenting)
            ->test(AddComment::class, [ 'idea' => $idea, ])
            ->set('body', 'This is the first comment')
            ->call('postComment');

        Livewire::actingAs($userBCommenting)
            ->test(AddComment::class, [ 'idea' => $idea, ])
            ->set('body', 'This is the second comment')
            ->call('postComment');

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->call('getNotifications')
            ->call('markAllAsRead');

        $this->assertEquals(0, $user->fresh()->unreadNotifications->count());
    }

    #[Test]
    public function can_mark_individual_notification_as_read()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create([
            'user_id' => $user->id,
        ]);

        $userACommenting = User::factory()->create();
        $userBCommenting = User::factory()->create();

        Livewire::actingAs($userACommenting)
            ->test(AddComment::class, [ 'idea' => $idea, ])
            ->set('body', 'This is the first comment')
            ->call('postComment');

        Livewire::actingAs($userBCommenting)
            ->test(AddComment::class, [ 'idea' => $idea, ])
            ->set('body', 'This is the second comment')
            ->call('postComment');

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->call('getNotifications')
            ->call('markAsRead', DatabaseNotification::first()->id)
            ->assertRedirect(route('idea.show', [
                'idea' => $idea,
                'page' => 1,
            ]));

        $this->assertEquals(1, $user->fresh()->unreadNotifications->count());
    }

    #[Test]
    public function notification_idea_deleted_redirects_to_index_page()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create([
            'user_id' => $user->id,
        ]);

        $userACommenting = User::factory()->create();

        Livewire::actingAs($userACommenting)
            ->test(AddComment::class, [ 'idea' => $idea, ])
            ->set('body', 'This is the first comment')
            ->call('postComment');

        $idea->comments()->delete();
        $idea->delete();

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->call('getNotifications')
            ->call('markAsRead', DatabaseNotification::first()->id)
            ->assertRedirect(route('idea.index'));
    }

    #[Test]
    public function notification_comment_deleted_redirects_to_index_page()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create([
            'user_id' => $user->id,
        ]);

        $userACommenting = User::factory()->create();

        Livewire::actingAs($userACommenting)
            ->test(AddComment::class, [ 'idea' => $idea, ])
            ->set('body', 'This is the first comment')
            ->call('postComment');

        $idea->comments()->delete();

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->call('getNotifications')
            ->call('markAsRead', DatabaseNotification::first()->id)
            ->assertRedirect(route('idea.index'));
    }
}
