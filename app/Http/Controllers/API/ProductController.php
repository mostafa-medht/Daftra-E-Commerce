<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use function Illuminate\Support\Facades\Process;

class ProductController extends BaseController
{
    protected ProductServices $productServices;

    public function __construct(ProductServices $productServices)
    {
        $this->productServices = $productServices;
    }

    /**
     * Display a list of products
    */
    public function index(Request $request)
    {
        try {
            $filters = $request->only(['name', 'min_price', 'max_price']);

            $products = $this->productServices->getAllProducts($filters);

            return $this->sendPaginatedResponse(ProductResource::collection($products), __('main.products_fetched_successfully'));
        }catch (\Throwable $throwable){
            Log::error("Get Products: Can't get products, ".$throwable->getMessage());
            return $this->sendError(__("main.can't_get_products").', ' . __("main.please_contact_support"));
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $productData = $request->validated();

            $product = $this->productServices->createProduct($productData);

            Log::info("Store Product: Store product with id {$product->id} successfully.");

            return $this->sendResponse(ProductResource::make($product), __('main.product_created_successfully'));
        }catch (\Throwable $throwable){
            Log::error("Store Product: Can't store product, ".$throwable->getMessage());
            return $this->sendError(__("main.can't_store_product").", ".__("main.please_contact_support"));
        }
    }

    public function update(UpdateProductRequest $request)
    {
        try {
            $productData = $request->validated();
            $product = $this->productServices->updateProduct($productData);

            Log::info("Update Product: Update product with id {$product->id} successfully.");

            return $this->sendResponse(ProductResource::make($product), __('main.product_updated_successfully'));
        }catch (\Throwable $throwable){
            Log::error("Update Product: Can't update product, ".$throwable->getMessage());
            return $this->sendError(__("main.can't_update_product").", ".__("main.please_contact_support"));
        }
    }
}
