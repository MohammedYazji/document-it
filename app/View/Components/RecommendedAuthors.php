<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class RecommendedAuthors extends Component
{
    public array $authors;

    public function __construct(public string $title = "Recommended Authors", public int $count = 4)
    {
        $user = Auth::user();

        // $sql = 'SELECT EXISTS (SELECT 1 FROM followers WHERE followers.user_id = ? AND follower_id = ?)';

        $this->authors = User::query()
            ->when($user, fn ($q) => $q->where('id', '!=', $user->id))
            ->withExists([
                'followers as is_followed' => fn ($q) => $q->where('follower_id', Auth::id() ?? 0),
            ])
            ->withCount('followers')
            ->limit($this->count)
            ->get()
            ->all();
    }

    public function render()
    {
        return view('components.widgets.recommended-authors');
    }
}
