<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $return = [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'details' => new ProductDetailResource($this->detail),
            'created_at' => date('d.m.Y H:i:s', strtotime($this->created_at))
        ];

        return $return;
    }
}
