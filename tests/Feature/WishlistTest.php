<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $category = Category::factory()->create(['status' => true]);
        $this->product = Product::factory()->create([
            'category_id' => $category->id,
            'status' => true,
            'stock' => 10,
        ]);
    }

    public function test_wishlist_requires_auth(): void
    {
        $response = $this->get('/wishlist');
        $response->assertRedirect('/login');
    }

    public function test_add_to_wishlist(): void
    {
        $response = $this->actingAs($this->user)->post('/wishlist/toggle/'.$this->product->id);
        $response->assertRedirect();

        $this->assertDatabaseHas('wishlists', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);
    }

    public function test_remove_from_wishlist(): void
    {
        $this->actingAs($this->user)->post('/wishlist/toggle/'.$this->product->id);

        $response = $this->actingAs($this->user)->delete('/wishlist/'.$this->product->id);
        $response->assertRedirect();

        $this->assertDatabaseMissing('wishlists', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);
    }

    public function test_wishlist_page(): void
    {
        $this->actingAs($this->user)->post('/wishlist/toggle/'.$this->product->id);

        $response = $this->actingAs($this->user)->get('/wishlist');
        $response->assertStatus(200);
        $response->assertSee($this->product->name);
    }
}
