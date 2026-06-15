<?php

namespace App\Jobs;

use App\Mail\WeeklyPostsSummary;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendNewPostsSummary implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $posts = Post::published()
            ->where('published_at', '>=', now()->subWeek())
            ->get();

        if ($posts->isEmpty()) {
            return;
        }

        $mailable = new WeeklyPostsSummary($posts);

        User::cursor()->each(function (User $user) use ($mailable) {
            Mail::to($user->email)->send($mailable);
        });
    }
}
