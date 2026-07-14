<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function created(Product $product): void
    {
        logActivity('Created', 'Product', "Product '{$product->name}' was created.");
    }

    public function updated(Product $product): void
    {
        $changed = $product->getChanges();
        unset($changed['updated_at']);
        if (empty($changed)) return;

        $fields = array_keys($changed);
        logActivity('Updated', 'Product', "Product '{$product->name}' was updated. (" . implode(', ', $fields) . ')');
    }

    public function deleted(Product $product): void
    {
        logActivity('Deleted', 'Product', "Product '{$product->name}' was deleted.");
    }

    public function restored(Product $product): void
    {
        logActivity('Restored', 'Product', "Product '{$product->name}' was restored.");
    }
}
