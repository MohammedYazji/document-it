<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FollowNotification extends Notification
{
    public function __construct(protected User $follower)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Follower')
            ->greeting("Hi {$notifiable->name},")
            ->line("{$this->follower->name} started following you on Document It.")
            ->action('View Profile', route('users.profile', $this->follower->username))
            ->line('Thank you for using Document It!')
            ->salutation('Best Regards')
            ->from('follow@doc.it', 'doc.it');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New Follower',
            'body' => "{$this->follower->name} started following you.",
            'link' => route('users.profile', $this->follower->username),
            'meta' => [
                'follower_id' => $this->follower->id,
                'follower_avatar' => $this->follower->avatar,
            ],
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => 'New Follower',
            'body' => "{$this->follower->name} started following you.",
            'link' => route('users.profile', $this->follower->username),
            'meta' => [
                'follower_id' => $this->follower->id,
                'follower_avatar' => $this->follower->avatar,
            ],
        ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
