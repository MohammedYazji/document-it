<?php

namespace App\Listeners;

use App\Models\Post;
use Illuminate\Support\Facades\Session;

class IncrementPostViews
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($post): void
    {
        if (is_array($post)) {
            $post = $post[0];
        }

        if (!($post instanceof \App\Models\Post)) {
            return;
        }

        $viewed = Session::get('viewed_posts', []);

        if (!in_array($post->id, $viewed)) {
            $post->increment('views');
            Session::push('viewed_posts', $post->id);
        }
    }
}
