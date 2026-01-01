<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id.'C404',
            'name' => $this->name,
            'created_at' => $this->created_at?->toDateTimeString(),
            // only include products if loaded
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
