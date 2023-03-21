<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchProductShopRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::all();
        return response(ProductResource::collection($product));
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response(new ProductResource($product));
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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

    public function sortName()
    {
        $product = Product::all()->sortBy('name');
        return response(ProductResource::collection($product));
    }

    public function sortShop()
    {
        $product = Product::all()->sortByDesc('shop');
        return response(ProductResource::collection($product));
    }

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
