<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Http\Requests\ProductStoreRequest;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $validated = $request->validated();
        $product = Product::create($validated);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos');

            $image = Image::create([
                'url' => $photoPath,
                'imageable_id' =>  $product->id,
                'imageable_type' => Product::class,
            ]);
        }

        return response()->json(['message' => 'category created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
