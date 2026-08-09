<?php

namespace App\Http\Controllers;

use App\Ai\Agents\SearchAgent;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request, SearchAgent $searchAgent)
    {
        $query = $request->query('q', '');

        if (empty($query)) {
            return view('search', ['posts' => collect(), 'query' => $query]);
        }

        $keywords = $this->expandQuery($query, $searchAgent);

        $posts = Post::query()
            ->published()
            ->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('title', 'LIKE', "%{$keyword}%")
                      ->orWhere('content', 'LIKE', "%{$keyword}%")
                      ->orWhere('excerpt', 'LIKE', "%{$keyword}%");
                }
            })
            ->with(['category', 'user'])
            ->withCount('likedBy')
            ->latest()
            ->paginate(10)
            ->appends(['q' => $query]);

        return view('search', compact('posts', 'query'));
    }

    protected function expandQuery(string $query, SearchAgent $searchAgent): array
    {
        try {
            $response = $searchAgent->prompt(
                "Expand this search query into related keywords and synonyms, comma-separated: {$query}"
            );
            $keywords = array_map('trim', explode(',', $response->structured['keywords']));
            return array_unique(array_merge([$query], $keywords));
        } catch (\Throwable $e) {
            return [$query];
        }
    }
}
