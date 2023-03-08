<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    use HasPaginatorResourceCollection;

    public function toArray($request)
    {
        return $this->returnPaginatedResource(function ($item, $key) {
            return new ProductResource($item);
        });
    }
}
