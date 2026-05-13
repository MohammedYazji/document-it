<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("categories")
            ->insert([
                'name' => 'General',
                'slug' => 'general',
                'description' => 'General category',
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        $category = DB::table("categories")
            ->where('slug', 'general')
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first();

        DB::table("posts")
            ->insert([
                'user_id' => 1,
                'title' => 'My First Post',
                'content' => 'My First Post Content',
                'slug' => 'my-first-post',
                'category_id' => $category->id,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }
}
