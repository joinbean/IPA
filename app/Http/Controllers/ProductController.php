<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchProductShopRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *      path="/products",
     *      operationId="getProducts",
     *      tags={"product"},
     *      summary="Get all products",
     *      description="Returns list of products",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="products", type="array", collectionFormat="multi",
     *                  @OA\Items(ref="#/components/schemas/ProductResource"),
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
        $product = Product::all();
        return response(ProductResource::collection($product));
    }

    /**
     * @OA\Post(
     *      path="/api/products",
     *      operationId="storeProducts",
     *      tags={"product"},
     *      summary="Create new product",
     *      description="Creates one new product",
     *      security={ {"bearerAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Enter product Data",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"shop_id", "name"},
     *                  @OA\Property(property="shop_id", type="integer", example="1"),
     *                  @OA\Property(property="name", type="string", example="USB cable"),
     *                  @OA\Property(property="image", type="string", format="binary"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="product", ref="#/components/schemas/ProductResource",),
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
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        if (is_null($request->file('image')?->store('image')))
        {
            $validated['image'] = null;
        } else
        {
            $validated['image'] = basename($request->file('image')->store('image'));
        }

        // $validated['image'] = basename($request->file('image')?->store('image'));

        $product = Product::create($validated);
        return response(new ProductResource($product));
    }

    /**
     * @OA\Get(
     *      path="/api/products/{productId}",
     *      operationId="showProduct",
     *      tags={"product"},
     *      summary="Show one product",
     *      description="Get one product by it's id",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Parameter(
     *          description="ID of product",
     *          in="path",
     *          name="productId",
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
     *              @OA\Property(property="shop", ref="#/components/schemas/ProductResource",),
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
    public function show(Product $product)
    {
        return response(new ProductResource($product));
    }

    /**
     * @OA\Post(
     *      path="/api/products/{productId}",
     *      operationId="updateProducts",
     *      tags={"product"},
     *      summary="Update a product",
     *      description="Update the parameters of a product",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Parameter(
     *          description="ID of product",
     *          in="path",
     *          name="productId",
     *          required=true,
     *          example="1",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Enter product Data",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(property="shop_id", type="integer", example="1"),
     *                  @OA\Property(property="name", type="string", example="USB cable"),
     *                  @OA\Property(property="image", type="string", format="binary"),
     *                  @OA\Property(property="_method", type="string", example="PUT"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="product", ref="#/components/schemas/ProductResource",),
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
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        if (array_key_exists('image', $validated))
        {
            if ($product->image !== null)
            {
                $image = storage_path('app/image/').$product->image;
                unlink($image);
            }

            if (is_null($request->file('image')?->store('image')))
            {
                $validated['image'] = null;
            } else
            {
                $validated['image'] = basename($request->file('image')->store('image'));
            }

            //$validated['image'] = str_replace('image/', '', $request->file('image')?->store('image'));
        }
        $product->update($validated);
        return response(new ProductResource($product));
    }

    /**
     * @OA\Delete(
     *      path="/api/products/{productId}",
     *      operationId="deleteProducts",
     *      tags={"product"},
     *      summary="Delete a product",
     *      description="Delete one product by it's id",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Parameter(
     *          description="ID of product",
     *          in="path",
     *          name="productId",
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
    public function destroy(Product $product)
    {
        if ($product->image !== null)
        {
            $image = storage_path('app/image/').$product->image;
            unlink($image);
        }
        $product->delete();
        return response(null, 204);
    }

    /**
     * @OA\Get(
     *      path="/api/products/sort/name",
     *      operationId="getProductsSortedByName",
     *      tags={"product"},
     *      summary="Get all products sorted by name",
     *      description="Returns list of products sorted by Name",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="products", type="array", collectionFormat="multi",
     *                  @OA\Items(ref="#/components/schemas/ProductResource"),
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
    public function sortName()
    {
        $product = Product::all()->sortBy('name');
        return response(ProductResource::collection($product));
    }

    /**
     * @OA\Get(
     *      path="/api/products/sort/shop",
     *      operationId="getProductsSortedByShop",
     *      tags={"product"},
     *      summary="Get all products sorted by shop",
     *      description="Returns list of products sorted by shop",
     *      security={ {"bearerAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="products", type="array", collectionFormat="multi",
     *                  @OA\Items(ref="#/components/schemas/ProductResource"),
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
    public function sortShop()
    {
        return response(ProductResource::collection(Product::all())->sortBy('shop.name')->values());
    }

    /**
     * @OA\Post(
     *      path="/api/products/filter/shop",
     *      operationId="getProductsFilteredByShop",
     *      tags={"product"},
     *      summary="Get all products filtered by shop",
     *      description="Returns list of products filtered by shop",
     *      security={ {"bearerAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Enter shop Data",
     *          @OA\JsonContent(
     *              required={"shop"},
     *              @OA\Property(property="shop", type="string", example="Digitec"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="products", type="array", collectionFormat="multi",
     *                  @OA\Items(ref="#/components/schemas/ProductResource"),
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
    public function filterShop(SearchProductShopRequest $request)
    {
        $product = Product::all();
        $product = $product->filter(function (Product $p) use ($request) {
            similar_text(strtoupper($p->shop->name), strtoupper($request->shop), $percent);
            return $percent > 50;
        });
        return response(ProductResource::collection($product));
    }
}
