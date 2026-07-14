<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function created(Category $category): void
    {
        logActivity('Created', 'Category', "Category '{$category->name}' was created.");
    }

    public function updated(Category $category): void
    {
        $changed = $category->getChanges();
        unset($changed['updated_at']);
        if (empty($changed)) return;

        $fields = array_keys($changed);
        logActivity('Updated', 'Category', "Category '{$category->name}' was updated. (" . implode(', ', $fields) . ')');
    }

    public function deleted(Category $category): void
    {
        logActivity('Deleted', 'Category', "Category '{$category->name}' was deleted.");
    }
}
