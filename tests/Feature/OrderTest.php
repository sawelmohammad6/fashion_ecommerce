<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Order $order;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $category = Category::factory()->create(['status' => true]);
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'status' => true,
            'stock' => 10,
            'price' => 29.99,
        ]);

        $this->order = Order::factory()->create([
            'user_id' => $this->user->id,
            'customer_name' => 'Jane Doe',
            'grand_total' => 59.98,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        $this->order->items()->create([
            'product_id' => $product->id,
            'price' => 29.99,
            'quantity' => 2,
        ]);
    }

    public function test_orders_page_requires_auth(): void
    {
        $response = $this->get('/orders');
        $response->assertRedirect('/login');
    }

    public function test_orders_page_shows_user_orders(): void
    {
        $response = $this->actingAs($this->user)->get('/orders');
        $response->assertStatus(200);
        $response->assertSee('Jane Doe');
    }

    public function test_order_detail_page(): void
    {
        $response = $this->actingAs($this->user)->get('/orders/'.$this->order->id);
        $response->assertStatus(200);
        $response->assertSee('#1');
    }

    public function test_order_success_page(): void
    {
        $response = $this->actingAs($this->user)->get('/order/success/'.$this->order->id);
        $response->assertStatus(200);
    }

    public function test_cannot_view_other_users_order(): void
    {
        $anotherUser = User::factory()->create();
        $response = $this->actingAs($anotherUser)->get('/orders/'.$this->order->id);
        $response->assertStatus(403);
    }
}
