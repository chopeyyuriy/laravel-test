<?php

namespace App\Http\Resources;

use Illuminate\Pagination\LengthAwarePaginator;

trait HasPaginatorResourceCollection
{

    protected function returnPaginatedResource($callback)
    {
        /** @var LengthAwarePaginator $resource */
        $resource = $this->resource;

        $items = $resource->getCollection()->map($callback)->all();

        $return = $resource->toArray();
        $return['data'] = $items;

        return $return;
    }
}
