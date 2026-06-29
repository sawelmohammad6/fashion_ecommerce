<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;

    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::factory()->create(['status' => true]);
        $this->product = Product::factory()->create([
            'category_id' => $this->category->id,
            'status' => true,
            'stock' => 10,
        ]);
    }

    public function test_products_index_page(): void
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee($this->product->name);
    }

    public function test_product_detail_page(): void
    {
        $response = $this->get('/products/'.$this->product->slug);
        $response->assertStatus(200);
        $response->assertSee($this->product->name);
    }

    public function test_products_by_category(): void
    {
        $response = $this->get('/category/'.$this->category->slug);
        $response->assertStatus(200);
        $response->assertSee($this->product->name);
    }

    public function test_product_not_found_returns_404(): void
    {
        $response = $this->get('/products/non-existent-product');
        $response->assertStatus(404);
    }
}
