<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
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
    $user = auth('sanctum')->user();
    $productsQuery = Product::with('images', 'category', 'brand', 'user');

    // check if the user is authenticated
    if ($user) {
        $productsQuery->where('user_id', $user->id);
    }

    // check if the user is searching for a product
    if ($request->has('search')) {
        $searchTerm = '%' . $request->search . '%';
        $productsQuery->where(function ($query) use ($searchTerm) {
            $query->where('name', 'LIKE', $searchTerm);
        });
    }

    // check if the user is filtering by price range
    if ($request->has('min_price') && $request->has('max_price')) {
        $minPrice = $request->min_price;
        $maxPrice = $request->max_price;
        $productsQuery->whereBetween('price', [$minPrice, $maxPrice]);
    }

    // check if the user is filtering by brand name
    if ($request->has('brand_name')) {
        $brandName = $request->brand_name;
        $productsQuery->whereHas('brand', function ($query) use ($brandName) {
            $query->where('Name', 'like', '%' . $brandName . '%');
        });
    }

    // check if the user is filtering by category name
    if ($request->has('category_name')) {
        $categoryName = $request->category_name;
        $productsQuery->whereHas('category', function ($query) use ($categoryName) {
            $query->where('Name', 'like', '%' . $categoryName . '%');
        });
    }

    // check if the user is sorting the products
    if ($request->has('sort_by')) {
        $sortBy = $request->sort_by;
        $sortOrder = $request->input('sort_order', 'asc');
        $productsQuery->orderBy($sortBy, $sortOrder);
    }

    // Paginate the products
    $perPage = $request->input('per_page', 10);
    $products = $productsQuery->paginate($perPage);

    // Return a success response
    return ProductResource::collection($products);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
    $validated = $request->validated();

    try {

        $product = Product::create($validated);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos');
            $product->addImage($photoPath);
        }

        if ($request->has('variants') && is_array($request->variants)) {
            foreach ($request->variants as $variant) {
                $product->variants()->create([
                    'color' => $variant['color'],
                    'price' => $variant['price'],
                ]);
            }
        }
        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to create product', 'error' => $e->getMessage()], 500);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $product = Product::with('image')->find($id);
        if ($product) {
            return ProductResource::make($product)->withDetail();
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

    // Update product details
    $product->update($validated);
    $product->updateImage($request);

    // Update variants if available
    if ($request->has('variants')) {
        foreach ($request->variants as $variantData) {
            if (isset($variantData['id'])) {
                $variant = ProductVariant::find($variantData['id']);

                if ($variant && $variant->product_id === $product->id) {
                    $variant->update([
                        'color' => $variantData['color'],
                        'price' => $variantData['price'],
                    ]);
                }
            } else {
                $product->variants()->create([
                    'color' => $variantData['color'],
                    'price' => $variantData['price'],
                ]);
            }
        }
    }

    return response()->json(['message' => 'Produk berhasil diupdate', 'produk' => $product]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    $product = Product::findOrFail($id);
    $product->delete();
    return response()->json(['message' => 'Product deleted successfully']);
    }

    public function showDeleted(Request $request)
    {
        $productsQuery = Product::with(['category', 'brand'])->onlyTrashed();
        $perPage = 5;
        $products = $productsQuery->paginate($perPage);

        return ProductResource::collection($products);
    }
    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        $product->restore();

        return response()->json(['message' => 'Produk berhasil dipulihkan.']);
}
}
