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
        'name' => $this->name,
        'Price' => $this->price,
        'brand_name' => $this->brand->Name,
        'category_name' => $this->category->Name,
        'user_id' => $this->user_id,
        'user_name' => $this->user->name,
    ];

    // Adding conditional for photo
    if ($this->image) {
        $data['photo'] = $this->image->url;
    } else {
        $data['photo'] = null;
    }

    // Adding additional details if isDetail is set to true
    if ($this->isDetail) {
        $data['description'] = $this->description;
        $data['stock'] = $this->stock;
    }
    if ($this->variants->isNotEmpty()) {
        $data['variants'] = $this->variants->map(function ($variant) {
            return [
                'color' => $variant->color,
                'price' => $variant->price,
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
