<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => $this->status,
            'values' => AttributeValueResource::collection($this->whenLoaded('values')),
            'values_count' => $this->whenCounted('values'),
            'created_at' => $this->created_at?->format('Y-m-d H:i'),
        ];
    }
}
