<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $imageUpload;

    public function __construct(ImageUploadService $imageUpload)
    {
        $this->imageUpload = $imageUpload;
    }

    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('products.name', 'LIKE', "%{$search}%")
                  ->orWhere('products.slug', 'LIKE', "%{$search}%")
                  ->orWhere('products.sku', 'LIKE', "%{$search}%")
                  ->orWhereHas('category', fn($c) => $c->where('name', 'LIKE', "%{$search}%"));
            });
        }

        if ($categoryId = $request->get('category')) {
            $query->where('category_id', $categoryId);
        }

        if ($stockFilter = $request->get('stock')) {
            if ($stockFilter === 'in') {
                $query->inStock();
            } elseif ($stockFilter === 'low') {
                $query->lowStock();
            } elseif ($stockFilter === 'out') {
                $query->outOfStock();
            }
        }

        if ($sort = $request->get('sort')) {
            $query->matchSort($sort);
        } else {
            $query->latest();
        }

        $products = $query->paginate(15)->withQueryString();
        $categories = Category::active()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->imageUpload->upload($request->file('image'), null, 'products');
        }

        if ($request->hasFile('gallery_images')) {
            $data['gallery_images'] = $this->imageUpload->uploadMultiple($request->file('gallery_images'), 'products');
        }

        $data['featured'] = $request->boolean('featured');
        $data['status'] = $request->boolean('status');
        $data['pre_order'] = $request->boolean('pre_order');

        $product = Product::create($data);

        $this->syncAttributeValues($product, $request->input('attribute_values', []));

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load([
            'category',
            'productAttributeValues.attribute',
            'productAttributeValues.attributeValue',
        ]);

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $product->load('productAttributeValues');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->imageUpload->upload($request->file('image'), $product->image, 'products');
        }

        if ($request->hasFile('gallery_images')) {
            $existingGallery = $product->gallery_images ?? [];
            $newImages = $this->imageUpload->uploadMultiple($request->file('gallery_images'), 'products');
            $data['gallery_images'] = array_merge($existingGallery, $newImages);
        }

        $data['featured'] = $request->boolean('featured');
        $data['status'] = $request->boolean('status');
        $data['pre_order'] = $request->boolean('pre_order');

        $product->update($data);

        $this->syncAttributeValues($product, $request->input('attribute_values', []));

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $this->imageUpload->delete($product->image);
        $this->imageUpload->deleteMultiple($product->gallery_images);
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function deleteGalleryImage(Product $product, $index)
    {
        $gallery = $product->gallery_images ?? [];
        if (isset($gallery[$index])) {
            $this->imageUpload->delete($gallery[$index]);
            unset($gallery[$index]);
            $product->update(['gallery_images' => array_values($gallery)]);
        }

        return back()->with('success', 'Gallery image removed.');
    }

    public function bulkUpdateStock(Request $request)
    {
        $data = $request->validate([
            'product_ids' => ['required', 'array', 'min:1'],
            'product_ids.*' => ['integer', 'exists:products,id'],
            'stock_value' => ['required', 'integer', 'min:0'],
        ]);

        $updated = Product::whereIn('id', $data['product_ids'])
            ->update(['stock' => $data['stock_value']]);

        $lowStockCount = Product::whereIn('id', $data['product_ids'])
            ->lowStock()->count();

        $message = "{$updated} product(s) updated to {$data['stock_value']} stock.";
        if ($lowStockCount > 0) {
            $message .= " {$lowStockCount} product(s) still low stock.";
        }

        return redirect()->route('admin.products.index')
            ->with('success', $message);
    }

    protected function syncAttributeValues(Product $product, array $attributeValueIds): void
    {
        $product->productAttributeValues()->delete();

        if (empty($attributeValueIds)) {
            return;
        }

        $values = AttributeValue::with('attribute')
            ->whereIn('id', $attributeValueIds)
            ->whereHas('attribute', fn ($q) => $q->where('status', true))
            ->get();

        $rows = [];
        foreach ($values as $value) {
            $rows[] = [
                'product_id' => $product->id,
                'attribute_id' => $value->attribute_id,
                'attribute_value_id' => $value->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        ProductAttributeValue::insert($rows);
    }
}
