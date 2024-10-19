<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_product()
    {
        // Create a user
        $user = User::factory()->create();

        // Act as the authenticated user
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/v1/products/store', [
            'name' => 'New Product',
            'price' => 99.99,
            'quantity' => 10,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', ['name' => 'New Product']);
    }
}
