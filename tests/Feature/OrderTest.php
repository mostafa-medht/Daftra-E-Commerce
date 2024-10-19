<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_fails_with_insufficient_stock()
    {
        // Create a user
        $user = User::factory()->create();

        // Act as the authenticated user
        $this->actingAs($user, 'sanctum');

        // Create a product with limited stock
        $product = Product::create([
            'name' => 'Test Product',
            'price' => 99.99,
            'quantity' => 5,
        ]);

        // Attempt to create an order with more stock than available
        $response = $this->postJson('/api/v1/orders/store', [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'products' => [
                ['id' => $product->id, 'quantity' => 10], // Requesting more than available
            ]
        ]);

        // Assert that the request fails and returns a meaningful error message
        $response->assertStatus(422);

        $response->assertJson([
            'message' => "main.can't_store_order, Insufficient stock for product: Test Product",
            'status' => false
        ]);

        // Ensure no changes were made to the database (order or stock)
        $this->assertEquals(5, $product->fresh()->quantity);
        $this->assertEquals(0, Order::count());
    }
}
