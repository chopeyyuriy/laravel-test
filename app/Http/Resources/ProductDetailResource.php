<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $return = [
            'product_id' => $this->product_id,
            'price' => $this->price,
            'stock' => $this->stock,
            'created_at' => date('d.m.Y H:i:s', strtotime($this->created_at))
        ];

        return $return;
    }
}
