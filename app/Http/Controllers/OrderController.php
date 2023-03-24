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
     *      path="/api/orders",
     *      operationId="getOrders",
     *      tags={"order"},
     *      summary="Get all orders",
     *      description="Returns list of orders",
     *      security={ {"bearerAuth": {} }},
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
        return response(OrderResource::collection($order)->values());
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
     * @OA\Get(
     *      path="/api/orders/{orderId}",
     *      operationId="showOrder",
     *      tags={"order"},
     *      summary="Show one order",
     *      description="Get one order by it's id",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Parameter(
     *          description="ID of order",
     *          in="path",
     *          name="orderId",
     *          required=true,
     *          example="1",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
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
    public function show(Order $order)
    {
        return response(new OrderResource($order));
    }

    /**
     * @OA\Put(
     *      path="/api/orders/{orderId}",
     *      operationId="updateOrder",
     *      tags={"order"},
     *      summary="Update a order",
     *      description="Update the parameters of a order",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Parameter(
     *          description="ID of order",
     *          in="path",
     *          name="orderId",
     *          required=true,
     *          example="1",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          description="Enter order Data",
     *          @OA\JsonContent(
     *              @OA\Property(property="note", type="string", example="Important note about order!"),
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
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $validated = $request->validated();
        $order->update($validated);
        return response(new OrderResource($order));
    }

    /**
     * @OA\Delete(
     *      path="/api/orders/{orderId}",
     *      operationId="deleteOrder",
     *      tags={"order"},
     *      summary="Delete one order",
     *      description="Delete one order by it's id",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Parameter(
     *          description="ID of order",
     *          in="path",
     *          name="orderId",
     *          required=true,
     *          example="1",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
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
    public function destroy(Order $order)
    {
        $order->delete();
        return response(null, 204);
    }

    /**
     * @OA\Get(
     *      path="/api/orders/sort/date/old",
     *      operationId="getOrdersByDateOld",
     *      tags={"order"},
     *      summary="Get all orders oldest first",
     *      description="Returns list of orders ordered ascending by date",
     *      security={ {"bearerAuth": {} }},
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
    public function sortDateAsc()
    {
        $order = Order::all();
        return response(OrderResource::collection($order)->sortBy('ordered_at')->values());
    }

    /**
     * @OA\Get(
     *      path="/api/orders/sort/date/new",
     *      operationId="getOrdersByDateNew",
     *      tags={"order"},
     *      summary="Get all orders newest first",
     *      description="Returns list of orders ordered descending by date",
     *      security={ {"bearerAuth": {} }},
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
    public function sortDateDesc()
    {
        $order = Order::all();
        return response(OrderResource::collection($order)->sortByDesc('ordered_at')->values());
    }

    /**
     * @OA\Get(
     *      path="/api/orders/sort/status",
     *      operationId="getOrdersBystatus",
     *      tags={"order"},
     *      summary="Get all orders ordered by status",
     *      description="Returns list of orders ordered by status",
     *      security={ {"bearerAuth": {} }},
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
    public function sortStatus()
    {
        $order = Order::all();
        $order = $order->sort(function ($a, $b) {
            return $b->status() - $a->status();
        });
        return response(OrderResource::collection($order)->values());
    }

    /**
     * @OA\Get(
     *      path="/api/orders/filter/status/open",
     *      operationId="getOrdersBystatusOpen",
     *      tags={"order"},
     *      summary="Get all orders filtered by open status",
     *      description="Returns list of orders filtered by open status",
     *      security={ {"bearerAuth": {} }},
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
    public function filterStatusOpen()
    {
        $order = Order::all();
        $open = $order->filter(function ($o) {
            return $o->status() === false;
        });
        return response(OrderResource::collection($open)->values());
    }

    /**
     * @OA\Get(
     *      path="/api/orders/filter/status/closed",
     *      operationId="getOrdersBystatusClosed",
     *      tags={"order"},
     *      summary="Get all orders filtered by closed status",
     *      description="Returns list of orders filtered by closed status",
     *      security={ {"bearerAuth": {} }},
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
    public function filterStatusClosed()
    {
        $order = Order::all();
        $closed = $order->filter(function ($o) {
            return $o->status() === true;
        });
        return response(OrderResource::collection($closed));
    }
}
