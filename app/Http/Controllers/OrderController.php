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
     * @OA\Get(
     *      path="/orders",
     *      operationId="getOrders",
     *      tags={"order"},
     *      summary="Get all orders",
     *      description="Returns list of orders",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="orders", type="array", collectionFormat="multi",
     *                  @OA\Items(ref="#/components/schemas/OrderResource"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {
        $order = Order::all();
        return response(OrderResource::collection($order));
    }

    /**
     * @OA\Post(
     *      path="/api/orders",
     *      operationId="storeOrders",
     *      tags={"order"},
     *      summary="Create new order",
     *      description="Creates one new order",
     *      security={ {"bearerAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Enter order Data",
     *          @OA\JsonContent(
     *              required={"note", "ordered_at"},
     *              @OA\Property(property="note", type="string", example="Is super important!"),
     *              @OA\Property(property="ordered_at", type="string", format="date", example="2000-02-02"),
     *              @OA\Property(property="orderProducts", type="array", collectionFormat="multi",
     *                  @OA\Items(
     *                      @OA\Property(property="product_id", type="integer", example="1"),
     *                      @OA\Property(property="volume", type="integer", example="10"),
     *                      @OA\Property(property="price", type="integer", example="100"),
     *                  ),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="order", ref="#/components/schemas/OrderResource",),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
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
