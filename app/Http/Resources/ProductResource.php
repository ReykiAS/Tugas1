<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
{
    $data = [
        'id' => $this->id,
        'Name' => $this->name,
        'Price' => $this->price,
        'Brand Name' => $this->brand->Name,
        'Category Name' => $this->category->Name,
        'User Id' => $this->user_id,
        'Shop Name' => $this->user->name,
    ];

    // Adding conditional for photo
    if ($this->image) {
        $data['photo'] = $this->image->url;
    } else {
        $data['photo'] = null;
    }

    // Adding additional details if isDetail is set to true
    if ($this->variants->isNotEmpty()) {
        $data['Variants'] = $this->variants->map(function ($variant) {
            return [
                'Color' => $variant->color,
                'Price' => $variant->price,
            ];
        });
    }

    return $data;
}

    public function withDetail()
    {
        $this->resource->isDetail = true;
        return $this;
    }

    public function with($request)
    {
        // Memastikan bahwa relasi images dimuat jika isDetail disetel ke true
        if ($this->resource->isDetail && !$this->resource->relationLoaded('image')) {
            $this->resource->load('image');
        }

        return parent::with($request);
    }
}
