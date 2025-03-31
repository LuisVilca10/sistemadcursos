<?php

namespace App\Http\Resources\Course\Category;

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
            "id" => $this->resource->id,
            "name" => $this->resource->name,
            "image" => env("APP_URL") . "storage/" . $this->resource->image,
            "category_id" => $this->resource->category_id,
            "category" => $this->resource->father ? [
                "name" => $this->resource->father->name,
                "image" => env("APP_URL") . "storage/" . $this->resource->father->image,
            ] : NULL,
            "state" => $this->resource->state,
        ];
    }
}
