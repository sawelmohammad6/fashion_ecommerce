<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $category = Category::factory()->create(['status' => true]);
        $this->product = Product::factory()->create([
            'category_id' => $category->id,
            'status' => true,
            'stock' => 10,
            'price' => 29.99,
        ]);
    }

    public function test_cart_page_with_empty_cart(): void
    {
        $response = $this->get('/cart');
        $response->assertStatus(200);
    }

    public function test_add_to_cart(): void
    {
        $response = $this->post('/cart/add/'.$this->product->id, ['quantity' => 2]);
        $response->assertRedirect();
        $this->assertNotEmpty(session('cart'));
    }

    public function test_update_cart(): void
    {
        $this->post('/cart/add/'.$this->product->id, ['quantity' => 1]);

        $response = $this->patch('/cart/update/'.$this->product->id, ['quantity' => 3]);
        $response->assertRedirect();

        $cart = session('cart');
        $this->assertEquals(3, $cart[$this->product->id]['quantity']);
    }

    public function test_remove_from_cart(): void
    {
        $this->post('/cart/add/'.$this->product->id, ['quantity' => 1]);

        $response = $this->delete('/cart/remove/'.$this->product->id);
        $response->assertRedirect();

        $this->assertArrayNotHasKey($this->product->id, session('cart', []));
    }

    public function test_clear_cart(): void
    {
        $this->post('/cart/add/'.$this->product->id, ['quantity' => 1]);

        $response = $this->delete('/cart/clear');
        $response->assertRedirect();

        $this->assertEmpty(session('cart', []));
    }
}
