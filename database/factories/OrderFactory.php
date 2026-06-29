<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'customer_name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'division' => fake()->city(),
            'district' => fake()->city(),
            'upazila' => fake()->streetName(),
            'postal_code' => fake()->postcode(),
            'address' => fake()->address(),
            'payment_method' => 'cash_on_delivery',
            'payment_status' => 'pending',
            'subtotal' => 0,
            'shipping_charge' => 9.99,
            'discount' => 0,
            'grand_total' => 0,
            'total' => 0,
            'status' => 'pending',
            'ordered_at' => now(),
        ];
    }
}
