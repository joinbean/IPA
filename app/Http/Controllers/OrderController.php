<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = Order::all();
        return response(OrderResource::collection($order));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = 1;
        $order = Order::create($validated);
        $order->orderProducts()->createMany($validated['orderProducts']);
        return response(new OrderResource($order));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return response(new OrderResource($order));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $validated = $request->validated();
        $order->update($validated);
        return response(new OrderResource($order));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response(null, 204);
    }

    public function sortDateAsc()
    {
        $order = Order::all();
        return response(OrderResource::collection($order)->sortBy('ordered_at'));
    }

    public function sortDateDesc()
    {
        $order = Order::all();
        return response(OrderResource::collection($order)->sortByDesc('ordered_at'));
    }

    public function sortStatus()
    {
        $order = Order::all();
        $order = $order->sort(function ($a, $b) {
            return $b->status() - $a->status();
        });
        return response(OrderResource::collection($order));
    }

    public function filterStatusOpen()
    {
        $order = Order::all();
        $open = $order->filter(function ($o) {
            return $o->status() === false;
        });
        return response(OrderResource::collection($open));
    }

    public function filterStatusClosed()
    {
        $order = Order::all();
        $closed = $order->filter(function ($o) {
            return $o->status() === true;
        });
        return response(OrderResource::collection($closed));
    }
}
