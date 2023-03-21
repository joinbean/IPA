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
     * Display a listing of the resource.
     */
    public function index()
    {
        $shops = Shop::all();
        return response(ShopResource::collection($shops));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShopRequest $request)
    {
        $validated = $request->validated();
        $shop = Shop::create($validated);
        return response(new ShopResource($shop));
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        return response(new ShopResource($shop));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShopRequest $request, Shop $shop)
    {
        $validated = $request->validated();
        $shop->update($validated);
        return response(new ShopResource($shop));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        $shop->delete();
        return response(null, 204);
    }
}
