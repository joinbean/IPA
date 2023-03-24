<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderProductRequest;
use App\Http\Requests\UpdateOrderProductRequest;
use App\Http\Resources\OrderProductWithOrderResource;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderProductController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/orderProducts",
     *      operationId="getOrderProducts",
     *      tags={"orderProduct"},
     *      summary="Get all ordered products",
     *      description="Returns list of ordered products",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="orderProducts", type="array", collectionFormat="multi",
     *                  @OA\Items(ref="#/components/schemas/OrderProductResource"),
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
        $orderProduct = OrderProduct::all();
        return response(OrderProductWithOrderResource::collection($orderProduct));
    }

    /**
     * @OA\Post(
     *      path="/api/orderProducts",
     *      operationId="storeOrderProducts",
     *      tags={"orderProduct"},
     *      summary="Create new ordered product",
     *      description="Creates one new ordered product",
     *      security={ {"bearerAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Enter ordered product Data",
     *          @OA\JsonContent(
     *              required={"order_id", "product_id", "volume", "price"},
     *              @OA\Property(property="order_id", type="integer", example="1"),
     *              @OA\Property(property="product_id", type="integer", example="1"),
     *              @OA\Property(property="volume", type="integer", example="5"),
     *              @OA\Property(property="price", type="integer", example="20"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="orderProduct", ref="#/components/schemas/OrderProductWithOrderResource",),
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
    public function store(StoreOrderProductRequest $request)
    {
        $validated = $request->validated();
        $orderProduct = OrderProduct::create($validated);
        return response(new OrderProductWithOrderResource($orderProduct));
    }

    /**
     * @OA\Get(
     *      path="/api/orderProducts/{orderProductId}",
     *      operationId="showOrderProduct",
     *      tags={"orderProduct"},
     *      summary="Show one ordered product",
     *      description="Get one ordered product by it's id",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Parameter(
     *          description="ID of ordered product",
     *          in="path",
     *          name="orderProductId",
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
     *              @OA\Property(property="orderProduct", ref="#/components/schemas/OrderProductWithOrderResource",),
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
    public function show(OrderProduct $orderProduct)
    {
        return response(new OrderProductWithOrderResource($orderProduct));
    }

    /**
     * @OA\Put(
     *      path="/api/orderProducts/{orderProductId}",
     *      operationId="updateOrderProducts",
     *      tags={"orderProduct"},
     *      summary="Update ordered product",
     *      description="Updates one ordered product",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Parameter(
     *          description="ID of ordered product",
     *          in="path",
     *          name="orderProductId",
     *          required=true,
     *          example="1",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Enter ordered product Data",
     *          @OA\JsonContent(
     *              @OA\Property(property="order_id", type="integer", example="1"),
     *              @OA\Property(property="product_id", type="integer", example="1"),
     *              @OA\Property(property="volume", type="integer", example="5"),
     *              @OA\Property(property="price", type="integer", example="20"),
     *              @OA\Property(property="recieved_at", type="string", example="2012-12-21"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="orderProduct", ref="#/components/schemas/OrderProductWithOrderResource",),
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
    public function update(UpdateOrderProductRequest $request, OrderProduct $orderProduct)
    {
        $validated = $request->validated();
        $orderProduct->update($validated);
        return response(new OrderProductWithOrderResource($orderProduct));
    }

    /**
     * @OA\Delete(
     *      path="/api/orderProducts/{orderProductId}",
     *      operationId="deleteOrderProduct",
     *      tags={"orderProduct"},
     *      summary="Delete one ordered product",
     *      description="Delete one ordered product by it's id",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Parameter(
     *          description="ID of ordered product",
     *          in="path",
     *          name="orderProductId",
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
    public function destroy(OrderProduct $orderProduct)
    {
        $orderProduct->delete();
        return response(null, 204);
    }
}
