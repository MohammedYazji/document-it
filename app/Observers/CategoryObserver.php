<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "deleting" event.
     */
    public function deleting(Category $category): void
    {
        $category->posts()->delete();
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        $category->posts()->onlyTrashed()->restore();
    }
}
