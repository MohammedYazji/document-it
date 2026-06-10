<?php

namespace App\Notifications;

use App\Models\User;
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
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("{$this->follower->name} followed you")
            ->line("{$this->follower->name} started following you on Document It.")
            ->action('View Profile', route('users.profile', $this->follower->username))
            ->line('Thank you for using Document It!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New Follower',
            'body'  => "{$this->follower->name} started following you.",
            'link'  => route('users.profile', $this->follower->username),
            'meta'  => [
                'follower_id'     => $this->follower->id,
                'follower_avatar' => $this->follower->avatoar,
            ],
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
