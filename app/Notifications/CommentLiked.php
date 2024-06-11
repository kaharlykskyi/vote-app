<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentLiked extends Notification implements ShouldQueue
{
    use Queueable;

    public Comment $comment;

    public User $liker;

    /**
     * Create a new notification instance.
     */
    public function __construct(Comment $comment, User $liker)
    {
        $this->comment = $comment;
        $this->liker = $liker;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $html = "liked your comment <span class='font-semibold'>\"{$this->comment->body}\"</span>";
        return [
            'url' => route('idea.show', $this->comment->idea->slug),
            'user_avatar' => $this->liker->getAvatar(),
            'user_name' => $this->liker->name,
            'html' => $html,
            'idea_id' => $this->comment->idea->id,
            'idea_slug' => $this->comment->idea->slug,
            'comment_id' => $this->comment->id,
        ];
    }
}
