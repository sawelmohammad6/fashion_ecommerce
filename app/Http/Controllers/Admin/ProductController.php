<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

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
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('slug', 'LIKE', "%{$search}%");
            });
        }

        if ($categoryId = $request->get('category')) {
            $query->where('category_id', $categoryId);
        }

        if ($stockFilter = $request->get('stock')) {
            if ($stockFilter === 'low') {
                $query->lowStock();
            } elseif ($stockFilter === 'out') {
                $query->outOfStock();
            }
        }

        $products = $query->latest()->paginate(15)->withQueryString();
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

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();

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

        $product->update($data);

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
}
