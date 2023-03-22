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
     *      path="/orderProducts",
     *      operationId="getOrderProducts",
     *      tags={"orderProduct"},
     *      summary="Get all ordered products",
     *      description="Returns list of ordered products",
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
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderProductRequest $request)
    {
        $validated = $request->validated();
        $orderProduct = OrderProduct::create($validated);
        return response(new OrderProductWithOrderResource($orderProduct));
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderProduct $orderProduct)
    {
        return response(new OrderProductWithOrderResource($orderProduct));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderProductRequest $request, OrderProduct $orderProduct)
    {
        $validated = $request->validated();
        $orderProduct->update($validated);
        return response(new OrderProductWithOrderResource($orderProduct));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderProduct $orderProduct)
    {
        $orderProduct->delete();
        return response(null, 204);
    }
}
