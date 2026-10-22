<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerApiCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return CustomerApiResource::collection($this->collection);
    }
}
