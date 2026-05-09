<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct()
    {
        $this->posts = include resource_path("data/posts.php");
    }

    public function index()
    {
        return view("index", ["posts" => $this->posts]);
    }

    public function show(int $id, string $slug = " ")
    {
        $post = null;
        foreach ($this->posts as $p) {
            if ($p['id'] === $id) {
                $post = $p;
                break;
            }
        }
        if (!$post) {
            abort(404);
        }

        return view("blog.article", ['id' => $id, 'slug' => $slug]);
    }
}
