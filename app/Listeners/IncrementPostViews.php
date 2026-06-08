<?php

namespace App\Listeners;

use App\Models\Post;
use Illuminate\Support\Facades\Cookie;

class IncrementPostViews
{
    /**
     * Handle the event.
     */
    public function handle($post): void
    {
        if (is_array($post)) {
            $post = $post[0];
        }

        if (!($post instanceof Post)) {
            return;
        }

        $cookie = Cookie::get('post-views');
        $viewed = $cookie ? unserialize($cookie) : [];

        if (!is_array($viewed)) {
            $viewed = [];
        }

        if (!in_array($post->id, $viewed)) {
            $post->increment('views');
            $viewed[] = $post->id;

            // Set cookie for 2 minutes
            Cookie::queue('post-views', serialize($viewed), 2);
        }
    }
}
