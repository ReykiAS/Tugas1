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

            $image = Image::create([
                'url' => $photoPath,
                'imageable_id' =>  $brand->id,
                'imageable_type' => Brand::class,
            ]);
        }

        return response()->json(['message' => 'brand created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::findOrFail($id);

        $photo =  $brand->images()->first();

        $responseData = [
            'brand' =>  $brand,
            'photo' => $photo ?? null,
        ];

        return response()->json($responseData);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RequestsBrandUpdateRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();
        $brand = brand::find($id);
        if (!$brand) {
            return response()->json(['message' => 'brand tidak ditemukan'], 404);
        }

        $brand->update($validated);

        if ($request->hasFile('photo')) {
            if ($brand->image) {
                Storage::delete($brand->image->url);
                $brand->image->delete();
            }

            $photoPath = $request->file('photo')->store('photos');
            $brand->image()->create([
                'url' => $photoPath,
                'imageable_id' => $brand->id,
            ]);
        }

        return response()->json(['message' => 'brand berhasil diupdate', 'brand' => $brand]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $brand = brand::findOrFail($id);

        $brand->delete();

        return response()->json(['message' => 'brand deleted successfully']);
    }
}
