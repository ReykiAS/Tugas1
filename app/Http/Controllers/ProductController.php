<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $user = auth()->user();
    $minPrice = $request->input('min_price');
    $maxPrice = $request->input('max_price');
    $name = $request->input('name');
    $sortBy = $request->input('sortBy', 'id');
    $sortOrder = $request->input('sortOrder', 'asc');

    $productsQuery = Product::with(['category', 'brand']);

    if ($user) {
        $productsQuery->where('user_id', $user->id);
    }

    if ($name) {
        $productsQuery->where(function ($query) use ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%')
                ->orWhereHas('category', function ($query) use ($name) {
                    $query->where('Name', 'LIKE', '%' . $name . '%');
                })
                ->orWhereHas('brand', function ($query) use ($name) {
                    $query->where('Name', 'LIKE', '%' . $name . '%');
                });
        });
    }

    if ($minPrice !== null && $maxPrice !== null) {
        $productsQuery->whereBetween('price', [$minPrice, $maxPrice]);
    }

    // Lakukan sorting menggunakan sortBy
    $products = $productsQuery->get()->sortBy(function ($product) use ($sortBy) {
        switch ($sortBy) {
            case 'category_name':
                return optional($product->category)->Name;
            case 'brand_name':
                return optional($product->brand)->Name;
            default:
                return $product->{$sortBy};
        }
    }, SORT_REGULAR, $sortOrder === 'desc');

    return ProductResource::collection($products);
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
            $product->addImage($photoPath);
        }

        return response()->json(['message' => 'Produk created successfully'], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $product = Product::with('image')->find($id);
        if ($product) {
            if ($user && $product->user_id == $user->id) {
                return ProductResource::make($product)->withDetail();
            } else {
                return response()->json(['message' => 'Anda tidak memiliki akses ke produk ini.'], 403);
            }
        } else {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product tidak ditemukan'], 404);
        }
        if ($product->user_id !== auth()->id()) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk memperbarui produk ini'], 403);
        }
        $product->update($validated);
        $product->updateImage($request);

        return response()->json(['message' => 'Produk berhasil diupdate', 'produk' => $product]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $product = Product::findOrFail($id);
    if (auth()->user()->id != $product->user_id) {
        return response()->json(['message' => 'Anda tidak memiliki izin untuk memperbarui produk ini.'], 403);
    }
    $product->delete();
    return response()->json(['message' => 'Product deleted successfully']);
}
}
