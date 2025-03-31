<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UserGResource extends JsonResource
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
            "lastname" => $this->resource->lastname,
            "email" => $this->resource->email,
            "role" => $this->resource->role,
            "username" => $this->resource->username,
            "state" => $this->resource->state,
            "created_at" => $this->resource->created_at->format("Y-m-d h:i:s"),
            "updated_at" => $this->resource->updated_at->format("Y-m-d h:i:s"),
            "profile_photo_path" => Str::contains($this->resource->profile_photo_url, 'storage/')
                ? $this->resource->profile_photo_url
                : $this->resource->profile_photo_url

        ];
    }
}
