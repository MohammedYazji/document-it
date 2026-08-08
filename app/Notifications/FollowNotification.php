<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class FollowNotification extends Notification
{
    public function __construct(protected User $follower)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New Follower',
            'body' => "{$this->follower->name} started following you.",
            'link' => route('users.profile', $this->follower->username),
            'meta' => [
                'follower_id' => $this->follower->id,
                'follower_name' => $this->follower->name,
                'follower_username' => $this->follower->username,
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
                'follower_name' => $this->follower->name,
                'follower_username' => $this->follower->username,
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
