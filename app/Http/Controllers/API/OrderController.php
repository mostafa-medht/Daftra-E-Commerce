<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Services\OrderServices;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class OrderController extends BaseController
{
    protected OrderServices $orderService;

    public function __construct(OrderServices $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(StoreOrderRequest $request)
    {
        try{
            $orderData = $request->validated();

            $order = $this->orderService->createOrder($orderData);

            Log::info("Store Order: Store product with id {$order->id} successfully.");

            return $this->sendResponse($order, __('main.order_created_successfully'), Response::HTTP_CREATED);
        }catch (\Exception $e){
            Log::error("Store Order: Can't store order, ".$e->getMessage());
            return $this->sendError(__("main.can't_store_order").", ". $e->getMessage(), code: Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch(\Throwable $throwable){
            Log::error("Store Product: Can't store product, ".$throwable->getMessage());
            return $this->sendError(__("main.can't_store_product").", ".__("main.please_contact_support"));
        }
    }

    public function show($orderId)
    {
        try{
            $order = $this->orderService->getOrderById($orderId);

            if($order){
                return $this->sendResponse($order, __('main.order_found'));
            }else {
                return $this->sendError(__("main.order_not_found"));
            }
        }catch(\Throwable $throwable){
            Log::error("Show Order: Can't show order, ".$throwable->getMessage());
            return $this->sendError(__("main.can't_show_order").", ".__("main.please_contact_support"));
        }
    }
}
