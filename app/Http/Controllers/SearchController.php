<?php

namespace App\Http\Controllers;

use App\Ai\Agents\SearchAgent;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request, SearchAgent $searchAgent)
    {
        $input = $request->query('q', '');
        $smart = false;
        $query = $input;

        if (str_starts_with($input, 'smart/')) {
            $smart = true;
            $query = substr($input, 6);
        }

        if (empty($query)) {
            return view('search', ['posts' => collect(), 'query' => $input, 'smart' => false, 'input' => $input]);
        }

        // Always do normal search first
        $posts = $this->normalSearch($query);

        // If smart and no results, try AI expansion
        if ($smart && $posts->isEmpty()) {
            $keywords = $this->expandQuery($query, $searchAgent);
            if (count($keywords) > 1) {
                $posts = $this->smartSearch($keywords);
            }
        }

        $posts = $posts->appends(['q' => $input, 'smart' => $smart ? '1' : '']);

        return view('search', compact('posts', 'query', 'smart', 'input'));
    }

    protected function normalSearch(string $query)
    {
        return Post::query()
            ->published()
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%")
                  ->orWhere('excerpt', 'LIKE', "%{$query}%")
                  ->orWhereHas('user', fn ($uq) => $uq->where('name', 'LIKE', "%{$query}%"));
            })
            ->with(['category', 'user'])
            ->latest()
            ->paginate(10);
    }

    protected function smartSearch(array $keywords)
    {
        return Post::query()
            ->published()
            ->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('title', 'LIKE', "%{$keyword}%");
                }
            })
            ->with(['category', 'user'])
            ->latest()
            ->paginate(10);
    }

    protected function expandQuery(string $query, SearchAgent $searchAgent): array
    {
        $cacheKey = 'search_expand_' . md5($query);

        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function () use ($query, $searchAgent) {
            try {
                \Illuminate\Support\Facades\Log::info('Smart search expanding: ' . $query);
                $response = $searchAgent->prompt(
                    "Given this search query about blog posts and coding articles, expand it into related keywords. Include the original query words too. Comma-separated: {$query}"
                );
                $keywords = array_map('trim', explode(',', $response->structured['keywords']));
                \Illuminate\Support\Facades\Log::info('Smart search expanded to: ' . implode(', ', $keywords));
                return array_unique(array_merge([$query], $keywords));
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Smart search AI failed: ' . $e->getMessage());
                return [$query];
            }
        });
    }
}
