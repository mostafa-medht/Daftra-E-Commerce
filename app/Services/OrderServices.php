<?php

namespace App\Services;

use App\Events\OrderPlaced;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderServices
{
    /**
     * Create a new Order and manage stock
     * @throws \Exception
     */
    public function createOrder(array $orderData)
    {
        $orderProducts = $orderData['products'];
        // get order products ids
        $productIds = $this->getProductsIdsForOrder($orderProducts);

        // Get all products by one query from database
        $products = Product::whereIn('id', $productIds)->get();

        // Attach products and adjust stock
        return DB::transaction(function () use ($orderData, $orderProducts, $products) {
            // Create order
            $order = Order::create([
                    'customer_name' => $orderData['customer_name'],
                    'customer_email' => $orderData['customer_email'],
                ]);

            // Loop through products and adjust stock
            foreach ($orderProducts as $productData) {
                // Find product in the products collection by its ID
                $product = $products->find('id', $productData['id']);

                if ($product->quantity < $productData['quantity']) {
                    throw new \Exception('Insufficient stock for product: ' . $product->name);
                }

                $product->decrement('quantity', $productData['quantity']);

                $order->products()->attach($product, ['quantity' => $productData['quantity']]);
            }

            // Trigger event for order placed
            event(new OrderPlaced($order));

            // return the created order
            return $order->load('products');
        }, 5); // Retry up to 5 times if deadlock occurs
    }

    private function getProductsIdsForOrder(array $orderProducts): array
    {
        // Extract product IDs
        return array_map(function($product) {
            return $product['id'];
        }, $orderProducts);
    }
}
