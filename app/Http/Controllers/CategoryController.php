<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Http\Resources\CategoryResource;
class CategoryController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();

        return CategoryResource::collection($category);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $validated = $request->validated();
        $category = Category::create($validated);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos');

            $image = Image::create([
                'url' => $photoPath,
                'imageable_id' =>  $category->id,
                'imageable_type' => Category::class,
            ]);
        }

        return response()->json(['message' => 'category created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        $photo =  $category->images()->first();

        $responseData = [
            'category' =>  $category,
            'photo' => $photo ?? null,
        ];

        return response()->json($responseData);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category tidak ditemukan'], 404);
        }

        $category->create($validated);

        if ($request->hasFile('photo')) {
            if ($category->image) {
                Storage::delete($category->image->url);
                $category->image->delete();
            }

            $photoPath = $request->file('photo')->store('photos');
            $category->image()->create([
                'url' => $photoPath,
                'imageable_id' => $category->id,
            ]);
        }

        return response()->json(['message' => 'Category berhasil diupdate', 'category' => $category]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
