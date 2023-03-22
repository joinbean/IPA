<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/shops",
     *      operationId="getStores",
     *      tags={"shop"},
     *      summary="Get all stores",
     *      description="Returns list of stores",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="shops", type="array", collectionFormat="multi",
     *                  @OA\Items(ref="#/components/schemas/ShopResource"),
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
        $shops = Shop::all();
        return response(ShopResource::collection($shops));
    }

    /**
     * @OA\Post(
     *      path="/api/shops",
     *      operationId="storeStore",
     *      tags={"shop"},
     *      summary="Create new store",
     *      description="Creates one new store",
     *      security={ {"bearerAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Enter shop Data",
     *          @OA\JsonContent(
     *              required={"name", "link"},
     *              @OA\Property(property="name", type="string", example="Digitec"),
     *              @OA\Property(property="link", type="string", example="www.digitec.ch"),
     *          ),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"name", "link"},
     *                  @OA\Property(property="name", type="string", example="Digitec"),
     *                  @OA\Property(property="link", type="string", example="www.digitec.ch"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="shop", ref="#/components/schemas/ShopResource",),
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
    public function store(StoreShopRequest $request)
    {
        $validated = $request->validated();
        $shop = Shop::create($validated);
        return response(new ShopResource($shop));
    }

    /**
     * @OA\Get(
     *      path="/api/shops/{shopId}",
     *      operationId="showStore",
     *      tags={"shop"},
     *      summary="Show one store",
     *      description="Get one store by it's id",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Parameter(
     *          description="ID of shop",
     *          in="path",
     *          name="shopId",
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
     *              @OA\Property(property="shop", ref="#/components/schemas/ShopResource",),
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
    public function show(Shop $shop)
    {
        return response(new ShopResource($shop));
    }

    /**
     * @OA\Put(
     *      path="/api/shops/{shopId}",
     *      operationId="updateStore",
     *      tags={"shop"},
     *      summary="Update a store",
     *      description="Update the parameters of a store",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Parameter(
     *          description="ID of shop",
     *          in="path",
     *          name="shopId",
     *          required=true,
     *          example="1",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          description="Enter shop Data",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Digitec"),
     *              @OA\Property(property="link", type="string", example="www.digitec.ch"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="shop", ref="#/components/schemas/ShopResource",),
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
    public function update(UpdateShopRequest $request, Shop $shop)
    {
        $validated = $request->validated();
        $shop->update($validated);
        return response(new ShopResource($shop));
    }

    /**
     * @OA\Delete(
     *      path="/api/shops/{shopId}",
     *      operationId="deleteStore",
     *      tags={"shop"},
     *      summary="Delete one store",
     *      description="Delete one store by it's id",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Parameter(
     *          description="ID of shop",
     *          in="path",
     *          name="shopId",
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
    public function destroy(Shop $shop)
    {
        $shop->delete();
        return response(null, 204);
    }
}
