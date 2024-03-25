<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest as RequestsBrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest as RequestsBrandUpdateRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Resources\BrandResource;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Http\Resources\BrandStoreRequest;
use App\Http\Resources\BrandUpdateRequest;
use Illuminate\Http\JsonResponse;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brand = Brand::all();
        return BrandResource::collection($brand);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestsBrandStoreRequest $request)
    {
        $validated = $request->validated();
        $brand = Brand::create($validated);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos');
            $brand->addImage($photoPath);
        }

        return response()->json(['message' => 'Brand created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::with('image')->find($id);

        if ($brand) {
            return BrandResource::make($brand)->withDetail();
        } else {
            return response()->json(['message' => 'Brand  tidak ditemukan'], 404);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(RequestsBrandUpdateRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json(['message' => 'Brand  tidak ditemukan'], 404);
        }
        $brand->update($validated);
        $brand->updateImage($request);

    return response()->json(['message' => 'Brand  berhasil diupdate', 'brand' => $brand]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $brand = brand::findOrFail($id);

        $brand->delete();

        return response()->json(['message' => 'Brand  deleted successfully']);
    }
    public function showDeleted()
    {
        $softDeletedBrands = Brand::onlyTrashed()->get();
        return response()->json(['data' => BrandResource::collection($softDeletedBrands)]);
    }
    public function restore($id)
    {
        $brand = Brand::withTrashed()->findOrFail($id);
        $brand->restore();

        return response()->json(['message' => 'Produk berhasil dipulihkan.']);
}
}
