<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductServices
{
    /**
     * Get all products with optional filters and caching
    */
    public function getAllProducts(array $filters)
    {
        return Cache::remember('products', 60, function () use ($filters) {
            $query = Product::query();

            if (isset($filters['name'])){
                $query->where('name', 'like', "%{$filters['name']}%");
            }

            if (isset($filters['min_price'])){
                $query->where('price', '>=', $filters['min_price']);
            }

            if (isset($filters['max_price'])){
                $query->where('price', '<=', $filters['max_price']);
            }

            return $query->paginate(10);
        });
    }

    /**
     * Create New Product
    */
    public function createProduct(array $productData)
    {
        return Product::create($productData);
    }

    public function updateProduct(array $productData)
    {
        $product = Product::find($productData['id']);

        $product->update($productData);

        return $product;
    }
}
