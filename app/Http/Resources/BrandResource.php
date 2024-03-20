<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->Name,
        ];

        // Pastikan isDetail disetel ke true dan relasi images dimuat
        if ($this->isDetail && $this->relationLoaded('images')) {
            // Ubah images menjadi images() jika relasinya menggunakan metode
            // hasMany atau morphMany di dalam model Category
            $data['photo'] = $this->images->map(function ($image) {
                return $image->url;
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
        if ($this->resource->isDetail && !$this->resource->relationLoaded('images')) {
            $this->resource->load('images');
        }

        return parent::with($request);
    }
}
